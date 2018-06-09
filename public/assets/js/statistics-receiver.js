$(document).ready(function () {
    $.ajax(
        {
            type: 'GET',
            url: '/top',
            data: JSON.stringify({
            }),
            processData: true,
            contentType: 'application/json',
            success: function (result) {

                var games = $.parseJSON(result);
                var html =
                    '<div style="margin-left: 15%; overflow: auto"><p><table>' +
                    '<h1 class="text-white"> Top 10 graczy:</h1>' +
                    '  <tr>' +
                    '    <th style="width: 10%"><b class="text-white">Gracz</b></th>' +
                    '    <th style="width: 10%"><b class="text-white">Zestrzelonych klingonów</b></th>'+
                    '  </tr>';
                $.each(games, function(index, element) {

                    html = html + '<tr>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.name+ '</b></td>' +
                        '    <td style="width: 10%"><b class="text-white">' + element.klingons_shoot+ '</b></td>' +
                        '  </tr>'


                });

                document.getElementById("hello").innerHTML = html+"</table></p></div>";
            }
        }

    );
});