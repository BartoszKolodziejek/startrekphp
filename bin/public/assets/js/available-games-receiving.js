$('#my-games').click(function () {
    $.ajax(
        {
            type: 'GET',
            url: '/myGames',
            success: function(result) {

                var games = $.parseJSON(result);
                var html =
                    '<div style="margin-left: 15%; overflow: auto"><p><table>' +
                    '<h1 class="text-white"> Lista dostępnych gier:</h1>' +
                    '  <tr>' +
                    '    <th style="width: 10%"><b class="text-white">Nazwa gry</b></th>' +
                    '    <th style="width: 10%"><b class="text-white">Gracze</b></th>'+
                    '    <th style="width: 10%"></th>'+
                    '  </tr>';
                $.each(games, function(index, element) {

                    html = html + '<tr>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.name+ '</b></td>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.players+'/'+ element.max_number+ '</b></td>' +
                        '    <td style="width: 10%"><button class="btn btn-primary" onclick="join('+element.id+')"><b class="text-white" id='+element.id+'>GRAJ!</button></td>' +
                        '    <td style="width: 10%"><p id="timer'+index+'" class="text-white"></p></td>' +
                        '  </tr>'
                    timer(element.time_stamp,'timer'+index );


                });

                document.getElementById("hello").innerHTML = html+"</table></p></div>";

            }
        }
    );
});
$('#available').click(function () {
    $.ajax(
        {
            type: 'GET',
            url: '/games',
            success: function(result) {

                var games = $.parseJSON(result);
                var html =
                    '<div style="margin-left: 15%; overflow: auto"><p><table>' +
                    '<h1 class="text-white"> Lista dostępnych gier:</h1>' +
                    '  <tr>' +
                    '    <th style="width: 10%"><b class="text-white">Nazwa gry</b></th>' +
                    '    <th style="width: 10%"><b class="text-white">Gracze</b></th>'+
                    '    <th style="width: 10%"></th>'+
                    '  </tr>';
                $.each(games, function(index, element) {

                    html = html + '<tr>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.name+ '</b></td>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.players+'/'+ element.max_number+ '</b></td>' +
                        '    <td style="width: 10%"><button class="btn btn-primary" onclick="join('+element.id+')"><b class="text-white" id='+element.id+'>GRAJ!</button></td>' +
                        '    <td style="width: 10%"><p id="timer'+index+'" class="text-white"></p></td>' +
                        '  </tr>'
                    timer(element.time_stamp,'timer'+index );


                });

                document.getElementById("hello").innerHTML = html+"</table></p></div>";

            }
        }
    );
});

function join(game) {


    $.ajax(
        {    type: 'GET',
            url: '/join',
            data:JSON.stringify({ games: game }),
            processData: true,
            contentType: 'application/json',
            success: function(result) {
                document.cookie = 'game='+game;

                result =  $.parseJSON(result);

               getQuadrant('', result);
            }
        }
        );

}
function createTable(tableData) {
    var table = document.createElement('table');
    var row = {};
    var cell = {};


    table.style.height = '100%';
    table.style.width = '100%';

    tableData.forEach(function(rowData) {
        row = table.insertRow(-1); // [-1] for last position in Safari

        rowData.forEach(function(cellData) {
            cell = row.insertCell();
            if(cellData.toString().length===0)
                cell.textContent = ".";

            else
                cell.textContent = cellData.toString();

            cell.style.width='13.75%';
            cell.style.height='13.75%';
        });
    });
    return table;
}

$(document).ready(function () {
    var input = document;




// Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {

        event.preventDefault();


        if (event.key === 'Enter') {
            var cookie = decodeURIComponent(document.cookie).split(';');
            var request =new Array();
            var command = document.getElementById('command').value;
            document.getElementById('command').value = "";
            var message = 'Polecenie?';

            $.ajax(
                {
                    type: 'GET',
                    url: '/command',
                    data: JSON.stringify({
                        command: command,
                        quadrant: getCookie('quadrant'),
                        game: getCookie('game'),
                        sector: getCookie('sector'),
                        stardays: getCookie('stardays'),
                        shield: getCookie('shield'),
                        energy: getCookie('energy'),
                        previousCommand: getCookie('previousCommand'),
                        torpedoes: getCookie('torpedoes')


                    }),
                    processData: true,
                    contentType: 'application/json',
                    success: function (result) {
                        var shouldGetQuadrant = true;

                        document.cookie =' previousCommand='+command;
                        try{
                            result =  $.parseJSON(result);
                        }
                        catch (e) {
                            document.getElementById('message-paragraph').innerText = result;
                            shouldGetQuadrant =false;
                        }
                        if(command!=='W'&&command!=='w'&&command!=='1'&&shouldGetQuadrant){
                        getQuadrant(command, result);
                        try{if(result.message)
                            alert(result.message)}
                        catch (e) {

                        }}

                        else
                            document.getElementById('message-paragraph').innerText = result;
                    }
                })
        }
        if (event.key === 'Escape') {
            $.ajax(
                {    type: 'GET',
                    url: '/join',
                    data:JSON.stringify({ games: getCookie('game') }),
                    processData: true,
                    contentType: 'application/json',
                    success: function(result) {

                        result =  $.parseJSON(result);

                        getQuadrant('', result);
                    }
                }
            );
        }
        if (event.key === 'F12') {
            window.open('/help');
        }

    });

});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getQuadrant(command, result) {
    $.ajax(
        {    type: 'GET',
            url: '/get_quadrant',
            data:JSON.stringify({
                quadrant: result.quadrant,
                game: getCookie('game'),
                command: command

            }),
            processData: true,
            contentType: 'application/json',
            success: function(data) {
                var mapOfQuadrant = $.parseJSON(data);

                var mapOfQuadrantAsArray = new Array(8);
                for(var i=0; i<8; i++){
                    mapOfQuadrantAsArray[i] = new Array(8);

                }
                $.each(mapOfQuadrant, function(index, element) {
                    mapOfQuadrantAsArray[element.Y][element.X] = element.type;
                });
                var not_end=true;
                if (command!=='L'&&command!=='l'&&command!=='G'&&command!=='g'){


                    do {
                        if (mapOfQuadrantAsArray[result.sector_Y][result.sector_X]==='.'){
                            mapOfQuadrantAsArray[result.sector_Y][result.sector_X] = 'E';
                            not_end=false;}
                        else {
                            if(result.sector_X>0 &&result.sector_Y>0 ){
                                result.sector_X = result.sector_X-1;
                                result.sector_Y = result.sector_Y-1;}
                            else if(result.sector_X<8 &&result.sector_Y<8) {
                                result.sector_X = result.sector_X+1;
                                result.sector_Y = result.sector_Y+1;
                            }
                        }
                    }
                    while (not_end);}




                var html =
                    '<div style="margin-left: 15%; overflow: hidden"><p><table>' +
                    '<tr>' +
                    '    <td style="width: 70%; height: 70%"><b class="text-white">' +
                    '<div  style="width: 100%; height: 100%">'+
                    createTable(mapOfQuadrantAsArray).innerHTML.replace('<tbody>', '<table>').replace('</tbody>', '</table>')+
                    '</div>'+
                    '</b></td>' +
                    '    <td style="width: 10%"><b class="text-white">' +
                    '<p>torpedy='+ result.torpedoes+'</p>'+
                    '<p>klingoni='+ result.klingons+'</p>'+
                    '<p>energia='+ result.energy+'</p>'+
                    '<p>tarcza='+ result.shield+'</p>'+
                    '<p>dni='+ result.stardays+'</p>'+
                    '<p>kondycja='+ result.conditions+'</p>' +
                    '<p>kwadrant=('+ result.quadrant_X+','+result.quadrant_Y+')</p>'+
                    '<p>sektor=('+ result.sector_X+','+result.sector_Y+')</p>' +
                    '</b></td>' +
                    '  </tr>';

                document.getElementById("hello").innerHTML = html+"</table></p></div>"+'<p class="text-white" id="message-paragraph" style="margin-left: 15%">Polecenie?</p><p><input type="text" ' +
                    'class="input-group-text" id="command" style="width: 100%; margin-top: 20%; alignment: center" ></p>';
                document.cookie = 'game='+result.game;
                document.cookie =' quadrant=' +result.quadrant;
                document.cookie =' sector='+result.sector;
                document.cookie =' stardays='+result.stardays;
                document.cookie =' shield='+result.shield;
                document.cookie =' energy='+result.energy;
                document.cookie =' previousCommand='+"";
                document.cookie =' torpedoes='+result.torpedoes;
            },


        }
    );

}
function timer(time_stamp, id) {

    var countDownDate = new Date(new Date(time_stamp).getTime() - new Date(time_stamp).getTimezoneOffset()*1000*60);
    countDownDate = new Date(countDownDate);



// Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date();


        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById(id).innerHTML = days + "d " + hours + "g "
            + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById(id).innerHTML = "MISJA ZAKOŃCZONA";
        }
    }, 1000);


};