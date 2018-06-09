<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Sector;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\DomCrawler\Form;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:2');
    }
public function index(){
    return view('admin-main');
}

public function create(){
    return view('admin-create-game');
}


    public function deleteGames(Request $request){
        $json =  json_decode(array_keys($request->all())[0], true);
        DB::table('games')->where('id','=',$json['id'])->delete();
        DB::table('states')->where('game','=',$json['id'])->delete();
        DB::table('achievements')->where('game','=',$json['id'])->delete();
        DB::table('settings_of_game')->where('id','=',$json['id'])->delete();
    }
    public function getGames(){
        return json_encode(DB::table('games')->get());
    }
    public function deleteGamesView(){
        return view('admin-delete-games');
    }

    public function deleteUsers(Request $request){
        $json =  json_decode(array_keys($request->all())[0], true);
        DB::table('users')->where('id','=',$json['id'])->delete();
        DB::table('states')->where('user','=',$json['id'])->delete();
        DB::table('achievements')->where('user','=',$json['id'])->delete();
    }
    public function getUsers(){
        return json_encode(DB::table('users')->get());
    }
    public function deleteUsersView(){
        return view('admin-delete-users');
    }


public function show(Request $request){

    /*saving to databse takes a lot of tme - it is 4160 records*/

    ini_set('max_execution_time', 600);

    $torpedoes = rand ( 10 , 20 );
    $energy = rand ( 500 , 2000 );
    $shields = rand ( 500 , 2000 );
    $settings = DB::table('settings_of_game') -> insertGetId(
        ['torpedoes' => $torpedoes, 'energy' => $energy, 'shields' => $shields]
    );

    $name_game =Input::get('name-game');
    $players = Input::get('number-of-players');
    $date = new DateTime('now');
   $date = date_timestamp_set($date,$date->getTimestamp()+Input::get('minutes')*60);
    $game = DB::table('games') -> insertGetId(
        ['name' => $name_game, 'max_number' => $players, 'settings_of_game' => $settings, 'time_stamp' => $date]
    );

/*generating quadrants*/
    for($i=0; $i<8; $i++){
        for($j=0; $j<8; $j++){
         $klingons = rand ( 0 , 3 );
         $stars = rand ( 0 , 8 );
         if($klingons>0)
             $starbases = 0;
         else
            $starbases = rand ( 0 , 1 );
            $quadrant = DB::table('quadrants') -> insertGetId(
                ['game' => $game, 'klingons' => $klingons, 'stars' => $stars, 'starbases'=> $starbases, 'X' =>$i, 'Y'=>$j ]);
            /*generating sectors*/
            $number_of_sectors = 63;
            $sectors = array();

            for($k=0; $k<8; $k++){
                for($m=0; $m<8; $m++){
                    $sector =  new Sector($quadrant, $k, $m);
                    $sectors[$k+$m*8] = $sector;
                    }
            }
            $sectors_range = $sectors;
            /*filling with klingons*/
            for($k=0; $k<$klingons; $k++){
                $rand = rand ( 0 , $number_of_sectors );
                $sectors[$rand] -> setType('K');
                $sector = $sectors[$rand];
                $sectors[$rand] = $sectors[$number_of_sectors];
                $sectors[$number_of_sectors] = $sector;
                $number_of_sectors--;

            }
            /*filling with stars*/
            for($k=0; $k<$stars; $k++){
                $rand = rand ( 0 , $number_of_sectors );
                $sectors[$rand] -> setType('*');
                $sector = $sectors[$rand];
                $sectors[$rand] = $sectors[$number_of_sectors];
                $sectors[$number_of_sectors] = $sector;
                $number_of_sectors--;

            }
            /*filling with starbases*/
            for($k=0; $k<$stars; $k++){
                $rand = rand ( 0 , $number_of_sectors );
                $sectors[$rand] -> setType('B');
                $sector = $sectors[$rand];
                $sectors[$rand] = $sectors[$number_of_sectors];
                $sectors[$number_of_sectors] = $sector;
                $number_of_sectors--;

            }

            foreach ($sectors as $sector)
                DB::table('sectors') -> insertGetId(
                    ['quadrant' => $sector->getQuadrant(), 'type' => $sector->getType(), 'X' => $sector->getX(), 'y'=> $sector->getY()]);
        }

    }
    return view('admin-game-created');

}
}
