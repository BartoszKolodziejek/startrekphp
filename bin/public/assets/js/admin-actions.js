$(document).ready(function () {
        $.ajax(
            {
                type: 'GET',
                url: '/get/users',
                data: JSON.stringify({
                }),
                processData: true,
                contentType: 'application/json',
                success: function (result) {

                    var games = $.parseJSON(result);
                    var html =
                        '<div style=" overflow: auto"><p><table>' +
                        '<h1 > Lista Graczy:</h1>' +
                        '  <tr>' +
                        '    <th style="width: 10%"><b >Gracz</b></th>' +
                        '    <th style="width: 10%"><b >Akcja</b></th>'+
                        '  </tr>';
                    $.each(games, function(index, element) {

                        html = html + '<tr>' +
                            '    <td style="width: 10%"><b >' + element.name+ '</b></td>' +
                            '    <td style="width: 10%"><button class="btn btn-danger" id='+element.id+' onClick=deleteUser('+element.id+')>Usuń</button> </td>' +
                            '  </tr>'


                    });

                    document.getElementById("users").innerHTML = html+"</table></p></div>";
                }
            }

        );
}

);

function deleteUser(id) {

    var performDelete = confirm("Użytkownik zostanie usunięty!");
    if(performDelete){
    $.ajax({
        type: 'GET',
        url: '/delete/user',
        data: JSON.stringify({
            id: id,
        }),
        processData: true,
        contentType: 'application/json',
        success: function (result) {
            document.getElementById(id).parentElement.parentElement.innerText="";

        }
    })
    }

}

$(document).ready(function () {
        $.ajax(
            {
                type: 'GET',
                url: '/get/games',
                data: JSON.stringify({
                }),
                processData: true,
                contentType: 'application/json',
                success: function (result) {

                    var games = $.parseJSON(result);
                    var html =
                        '<div style=" overflow: auto"><p><table>' +
                        '<h1 > Lista Gier:</h1>' +
                        '  <tr>' +
                        '    <th style="width: 10%"><b >Gra</b></th>' +
                        '    <th style="width: 10%"><b >Akcja</b></th>'+
                        '  </tr>';
                    $.each(games, function(index, element) {

                        html = html + '<tr>' +
                            '    <td style="width: 10%"><b >' + element.name+ '</b></td>' +
                            '    <td style="width: 10%"><button class="btn btn-danger" id='+element.id+' onClick=deleteGame('+element.id+')>Usuń</button> </td>' +
                            '  </tr>'


                    });

                    document.getElementById("games").innerHTML = html+"</table></p></div>";
                }
            }

        );
    }

);

function deleteGame(id) {

    var performDelete = confirm("Gra zostanie usunięta!");
    if(performDelete){
        $.ajax({
            type: 'GET',
            url: '/delete/game',
            data: JSON.stringify({
                id: id,
            }),
            processData: true,
            contentType: 'application/json',
            success: function (result) {
                document.getElementById(id).parentElement.parentElement.innerText="";

            }
        })
    }

}