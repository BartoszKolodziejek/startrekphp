$('#form').submit(function () {
        document.getElementById("waiting-div").innerHTML =  '<i class="fa fa-gear fa-spin" style="font-size:24px"></i>' +'<i class="text-info">Tworzenie gry, może to zająć kilka minut</i>' +
            '<i class="fa fa-gear fa-spin" style="font-size:24px"></i>';

}
);