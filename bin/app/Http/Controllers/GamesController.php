<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use Psy\Util\Json;
use Symfony\Component\Console\Input\Input;

class GamesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private $previousCommand;

    public function myGames(Request $request){
        $id = Auth::user()-> id;
        return json_encode(DB::select(DB::raw('
select * from(
SELECT
    games.*,
    IFNULL(number_of_player.players, 0) players
    FROM
    games
    LEFT OUTER JOIN (
        SELECT
            games.*,
            COUNT(states.id) AS players
        FROM
            games left outer
            JOIN states ON games.id = states.game
            group by(game)
            
    ) number_of_player ON games.id = number_of_player.id
           
    where games.time_stamp > UTC_TIMESTAMP()) target
     left outer JOIN states ON target.id = states.game
    where target.players < max_number
    and user = '.$id)));
    }


    public function index(){

/*query do wyświrtlania dostępnych gier*/
        return json_encode(DB::select(DB::raw('select * from(
SELECT
    games.*,
    IFNULL(number_of_player.players, 0) players
    FROM
    games
    LEFT OUTER JOIN (
        SELECT
            games.*,
            COUNT(states.id) AS players
        FROM
            games left outer
            JOIN states ON games.id = states.game
            group by(game)
            
    ) number_of_player ON games.id = number_of_player.id
    where games.time_stamp > UTC_TIMESTAMP()) target
    where target.players < max_number')));
    }

    public function join(Request $request)
    {

        $user = Auth::user()->id;
        $game = json_decode(array_keys($request->all())[0], true)['games'];
        $user_is_in_game = DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->exists();
        if (!$user_is_in_game) {
            $settings = DB::table('games')->
            join('settings_of_game', 'games.settings_of_game', '=', 'settings_of_game.id')->
            where('games.id', '=', $game) -> get();
            $settings = json_decode(json_encode($settings[0]), true);
            $klingons = DB::table('quadrants')->
            where('game', '=', $game)
                ->where('klingons', '>', 0)
                ->count();
            $max_quadrant = DB::table('quadrants')->
            where('game', '=', $game)
                ->max('id');
            $min_quadrant = DB::table('quadrants')->
            where('game', '=', $game)
                ->min('id');
            $quadrant = rand($min_quadrant, $max_quadrant);
            $max_sector = DB::table('sectors')->
            where('quadrant', '=', $quadrant)
                ->max('id');
            $min_sector = DB::table('sectors')->
            where('quadrant', '=', $quadrant)
                ->min('id');
            $sector = rand($min_sector, $max_sector);
          $condition = $this -> getConditionPoints($settings);

            DB::table('states') -> insertGetId(
                ['user'=> $user, 'game' => $game,
                    'torpedoes' => $settings['torpedoes'],
                    'energy' => $settings['energy'],
                    'shield' => $settings['shields'],
                    'quadrant' => $quadrant,
                    'klingons' => $klingons,
                    'stardays' => 30,
                    'sector' => $sector,
                    'conditions'=> $condition

                ]
            );
            }
        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        return json_encode($state);

    }//

    public function getMapOfQuadrant(Request $request){
        $json =  json_decode(array_keys($request->all())[0], true);
        $command = $json['command'];
        $quadrant = $json['quadrant'];
        $user = Auth::user() -> id;
        if($command === 'G' || $command === 'g'){
            return json_encode(DB::select(DB::raw("select *, if((id in (select value from achievements where achievement like 'discovery')) 
            , CONCAT(Klingons, Starbases, Stars), '---') as type from quadrants where game = ".$json['game'])));
        }
       else if($command === 'L' || $command === 'l'){
            $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
            $results = collect(DB::select(DB::raw("select *, if(((X BETWEEN ".($quadrant_details['X']-1)." AND ".($quadrant_details['X']+1).") 
            
        AND (Y BETWEEN ".($quadrant_details['Y']-1)." AND ".($quadrant_details['Y']+1).")), CONCAT(Klingons, Starbases, Stars), '---') type from quadrants where game =".$json['game']))) -> toArray();
            foreach ($results as $result){
                $result = collect($result)->toArray();
                if(!($result['type']==='---')){
                    DB::table('achievements')
                        -> insertGetId(['user' => $user, 'game' => $json['game'], 'quadrant' => $quadrant, 'value' => $result['id'], 'achievement' => 'discovery']);
                }
            }
        return json_encode(DB::select(DB::raw("select *, if(((X BETWEEN ".($quadrant_details['X']-1)." AND ".($quadrant_details['X']+1).") 
        AND (Y BETWEEN ".($quadrant_details['Y']-1)." AND ".($quadrant_details['Y']+1).")), CONCAT(Klingons, Starbases, Stars), '---') type from quadrants where game =".$json['game'])));
        }

        return json_encode(DB::table('sectors')->where('quadrant', '=', $quadrant)->orderBy('id')->get());
    }
    private function sensors($command, $quadrant, $game, $user, $stardays, $shield, $sector){
        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        return json_encode($state);

    }
     private function warp_engine($command, $quadrant, $game, $user, $stardays, $shield, $sector, $energy){

        if($command[0]<0 || $command[0]>7 || $command[1]>10 || $command[1]<0 ){
            return 'Złe dane sir!';}
        $command = explode( "_", $command);
        $energy = $energy - 16*$command[1];
        $quadrant = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant) -> get())[0]), true);
        $X = floatval($quadrant['X'])+0.5;
        $Y = floatval($quadrant['Y']) +0.5;
        $angle = floatval($command[0])* 0.785398;
        $delta_x = cos($angle);
        $delta_y = -sin($angle);
        $number = $command[1];
        $update = true;
        for ($i=1; $i<=$number; $i++ ){
            if($X+$delta_x>=8 || $X+ $delta_x<=0 || $Y+$delta_y>=8 || $Y+$delta_y<=0){
                $update = false;
                break;}
            $X = $X + $delta_x;
            $Y = $Y + $delta_y;
            $quadrant = json_decode(json_encode(DB::table('quadrants')
                -> where('X', '=', intval($X))
                -> where('Y', '=', intval($Y))
                -> where('game', '=', $game)
                -> get()[0]), true);
            /*klingons attacks when passing through*/
            if(intval($quadrant['Klingons'])>0)
                $shield = $shield - intval($quadrant['Klingons'])*50;
        }

        $quadrant = json_decode(json_encode(DB::table('quadrants')
            -> where('X', '=', intval($X))
            -> where('Y', '=', intval($Y))
            -> where('game', '=', $game)
            -> get()), true)[0];
         $max_sector = DB::table('sectors')->
            where('quadrant', '=', $quadrant['id'])
                ->max('id');
        $min_sector = DB::table('sectors')->
            where('quadrant', '=', $quadrant['id'])
                ->min('id');
            if($update)
            $sector = rand($min_sector, $max_sector);

            $settings['energy'] = $energy;
            $settings['shields'] = $shield;

        DB::table('states')
            -> where('user', '=', $user)
            -> where('game', '=', $game)
            ->update(['quadrant' => $quadrant['id'], 'stardays' => $stardays-1, 'shield' => $shield, 'sector' => $sector, 'energy' => $energy, 'conditions' => $this -> getConditionPoints($settings)]);

        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        return json_encode($state);

    }

    public function eventHandler(Request $request){
        $json =  json_decode(array_keys($request->all())[0], true);
        $command = $json['command'];
        $quadrant = $json['quadrant'];
        $sector = $json['sector'];
        $game = $json['game'];
        $user = Auth::user()->id;
        $previousCommand =  $json['previousCommand'];
        $stardays = $json['stardays'];
        $energy = $json['energy'];
        $shield = $json['shield'];
        $torpedoes = $json['torpedoes'];
        $klingons = DB::table('quadrants')->
        where('game', '=', $game)
            ->where('klingons', '>', 0)
            ->count();
        if($energy<=0||$shield<=0||$stardays<=0){
            return 'Misja zakończona niepowodzeniem, sir!';
        }
        $game_details = collect(DB::table('games') -> where('id', '=', $game) ->get()[0])->toArray();
        if(new DateTime($game_details['time_stamp'])<(new DateTime('now'))||$klingons==0){
            return 'Misja zakończona, sir!';}
        switch ($command){
            case 'W':
                return 'Wybierz kurs, jeśli potrzbujesz pomocy wciśnij F12';
            case 'w':
                return 'Wybierz kurs, jeśli potrzbujesz pomocy wciśnij F12';
            case 'L':
                return $this -> sensors($command, $quadrant, $game, $user, intval($stardays),$shield, $sector);
            case 'l':
                return $this -> sensors($command, $quadrant, $game, $user, intval($stardays),$shield, $sector);
            case 'P':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 'p':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 't':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 'T':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 's':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 'S':
                return 'Wybierz kierunek, jeśli potrzbujesz pomocy wciśnij F12';
            case 'G':
                return $this -> sensors($command, $quadrant, $game, $user, intval($stardays),$shield, $sector);
            case 'g':
                return $this -> sensors($command, $quadrant, $game, $user, intval($stardays),$shield, $sector);


        }
        switch ($previousCommand){
            case 'W':
                return $this -> warp_engine($command, $quadrant, $game, $user, intval($stardays),$shield, $sector, $energy);
            case 'w':
                return $this -> warp_engine($command, $quadrant, $game, $user, intval($stardays),$shield, $sector, $energy);
            case 'P':
                return $this -> phasers($command, $quadrant,$sector, $energy, $user, $shield, $game);
            case 'p':
                return $this -> phasers($command, $quadrant,$sector, $energy, $user, $shield, $game);
            case 't':
                return $this -> torpedoes($command, $quadrant,$sector, $torpedoes, $user, $shield, $game);
            case 'T':
                return $this -> torpedoes($command, $quadrant,$sector, $torpedoes, $user, $shield, $game);
            case 's':
                return $this -> shortRangeEngine($command, $quadrant,$sector, $energy, $user, $game);
            case 'S':
                return $this -> shortRangeEngine($command, $quadrant,$sector, $energy, $user, $game);
            default:
                return 'Jeśli potrzbujesz pomocy wciśnij F12';


        }

    }

    private function getConditionPoints($settings)
    {
        $condition_points = $settings['energy']+$settings['shields'];
        $condition='';
        switch ($condition_points ) {
            case $condition_points <1000:
                return $condition = 'czerwona';
                break;
            case $condition_points <3000:
                return $condition = 'żółta';
                break;
            default:
                return $condition = 'zielona';
                break;
        }
    }

    private function shooting($command, $quadrant,$sector, $all, $game, $user){
        if($command[0]<0 || $command[0]>7  ){
            return 'Złe dane sir!';}
        $command = explode( "_", $command);
        $sector = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector) -> get())[0]), true);
        $X = floatval($sector['X'])+0.5;
        $Y = floatval($sector['Y']) +0.5;
        $angle = floatval($command[0])* 0.785398;
        $delta_x = cos($angle);
        $delta_y = -sin($angle);
        $process = true;
        $result = [];
        $message = 'brak efektu';
        $steps=0;
        do{
            if($X+$delta_x>=8 || $X+ $delta_x<=0 || $Y+$delta_y>=8 || $Y+$delta_y<=0){
                $process = false;
                break;}
            $X = $X + $delta_x;
            $Y = $Y + $delta_y;
            $sector = json_decode(json_encode(DB::table('sectors')
                -> where('X', '=', intval($X))
                -> where('Y', '=', intval($Y))
                -> where('quadrant', '=', $quadrant)
                -> get()[0]), true);
            if($sector['type']==='K'){
                DB::table('sectors') -> where('id', '=', $sector['id'])
                    -> update(['type' => '.']);
                $process =false;
                DB::table('achievements') -> insertGetId(['game' => $game, 'quadrant'=>$quadrant, 'achievement' => 'klingon', 'value' => 1, 'user'=>$user]);
                $message='Klingon zniszczony!';
                $quadrant = json_decode(json_encode(DB::table('quadrants')
                    -> where('id', '=', $quadrant)
                    -> get()[0]), true);
                $klingons = intval($quadrant['Klingons'])-1;
                DB::table('quadrants') -> where('id', '=', $quadrant['id'])
                    -> update(['Klingons' => $klingons]);
                $klingons = DB::table('quadrants')->
                where('game', '=', $game)
                    ->where('klingons', '>', 0)
                    ->count();

                DB::table('states') -> update(['Klingons'=> $klingons-1]);



            }
            if($all){
                if($sector['type']==='*')
                    $process =false;
                else if($sector['type']==='B')
                    $process =false;

            }
            $steps++;

        }

        while($process);

        $result[0] = $message;
        $result[1] = $steps;
        return $result;
    }

    private function phasers($command, $quadrant,$sector, $energy, $user, $shield, $game){

        $result = $this ->  shooting($command, $quadrant,$sector, false, $game, $user);
        $energy = $energy - $result[1]*4;
        $quadrant = json_decode(json_encode(DB::table('quadrants')
           ->where('id', '=', $quadrant)
            -> get()[0]), true);
        /*attack of klingons*/
        if(intval($quadrant['Klingons'])>0)
            $shield = $shield - intval($quadrant['Klingons'])*50;
        DB::table('states')
            -> where('user', '=', $user)
            -> where('game', '=', $game)
            ->update(['quadrant' => $quadrant['id'],  'shield' => $shield, 'energy' => $energy]);



        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        $state = array_add($state, 'message', $result[0]);
        return json_encode($state);



    }
    private function torpedoes($command, $quadrant,$sector, $torpedoes, $user, $shield, $game){
        if($torpedoes==0)
            return "Nie ma torped, sir!";
        $result = $this ->  shooting($command, $quadrant,$sector, true, $game, $user);
        $torpedoes = $torpedoes-1;
        $quadrant = json_decode(json_encode(DB::table('quadrants')
            ->where('id', '=', $quadrant)
            -> get()[0]), true);
        /*attack of klingons*/
        if(intval($quadrant['Klingons'])>0)
            $shield = $shield - intval($quadrant['Klingons'])*50;
        DB::table('states')
            -> where('user', '=', $user)
            -> where('game', '=', $game)
            ->update(['quadrant' => $quadrant['id'],  'shield' => $shield, 'torpedoes' => $torpedoes]);



        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        $state = array_add($state, 'message', $result[0]);
        return json_encode($state);



    }

    private function shortRangeEngine($command, $quadrant,$sector, $energy, $user, $game)
    {
        if($command[0]<0 || $command[0]>7 || $command[1]>10 || $command[1]<0 ){
            return 'Złe dane sir!';}
        $message='';
        $command = explode("_", $command);
        $sector = json_decode(json_encode((DB::table('sectors')->where('id', '=', $sector)->get())[0]), true);
        $X = floatval($sector['X']) + 0.5;
        $Y = floatval($sector['Y']) + 0.5;
        $angle = floatval($command[0]) * 0.785398;
        $delta_x = cos($angle);
        $delta_y = -sin($angle);
        $number = $command[1];
        $update = true;
        for ($i = 1; $i <= $number; $i++) {
            if ($X + $delta_x >= 8 || $X + $delta_x <= 0 || $Y + $delta_y >= 8 || $Y + $delta_y <= 0) {
                $update = false;
                break;
            }
            $X = $X + $delta_x;
            $Y = $Y + $delta_y;
            $sector = json_decode(json_encode(DB::table('sectors')
                ->where('X', '=', intval($X))
                ->where('Y', '=', intval($Y))
                ->where('quadrant', '=', $quadrant)
                ->get()[0]), true);
            $type = $sector['type'];
            if($type==='*'||$type==='K'||$type==='B'){
                $X = $X - $delta_x;
                $Y = $Y - $delta_y;
                $sector = json_decode(json_encode(DB::table('sectors')
                    ->where('X', '=', intval($X))
                    ->where('Y', '=', intval($Y))
                    ->where('quadrant', '=', $quadrant)
                    ->get()[0]), true);
            }

        }

        $energy = $energy - $command[1] * 6;

        /*docking to base*/
        $near_sectors = collect(DB::table('sectors')->whereBetween('X', [intval($X)-1, intval($X)+1])->whereBetween('Y', [intval($Y)-1, intval($Y)+1])->where('quadrant', '=', $quadrant)->get())->toArray();
        foreach ($near_sectors as $near_sector ){
           $near_sector = collect($near_sector)->toArray();
            if($near_sector['type']==='B'){
                $energy = 2000;
                $torpedoes = 20;
                $shield = 2000;
                DB::table('states')
                    -> where('user', '=', $user)
                    -> where('game', '=', $game)
                    ->update(['sector' => $sector['id'],  'energy' => $energy, 'torpedoes' => $torpedoes, 'shield' => $shield, 'conditions' => 'zielona' ]);
                $message= 'Zapasy uzupełnione, sir!';
                break;
            }
        }

        DB::table('states')
            -> where('user', '=', $user)
            -> where('game', '=', $game)
            ->update(['sector' => $sector['id'],  'energy' => $energy ]);
        $state = json_decode(json_encode((DB::table('states')->where('user', '=', $user)->where('game', '=', $game)->get())[0]), true);
        $sector = $state['sector'];
        $quadrant = $state['quadrant'];
        $sector_details = json_decode(json_encode((DB::table('sectors') -> where('id', '=', $sector)->get())[0]), true);
        $quadrant_details = json_decode(json_encode((DB::table('quadrants') -> where('id', '=', $quadrant)->get())[0]), true);
        $state =  array_add($state, 'sector_X', $sector_details['X']);
        $state = array_add($state, 'sector_Y', $sector_details['Y']);
        $state =  array_add($state, 'quadrant_X', $quadrant_details['X']);
        $state = array_add($state, 'quadrant_Y', $quadrant_details['Y']);
        $state = array_add($state, 'message', $message);
        return json_encode($state);


    }
    public function top(Request $request){
        return json_encode(DB::select(DB::raw('select users.name, count(value) klingons_shoot  from achievements
        join users on achievements.user = users.id
        where achievement like \'klingon\'
        group by user
        order by klingons_shoot
        limit 10')));
    }




}
