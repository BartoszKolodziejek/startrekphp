$(document).ready(function(){
    var elem = document.getElementById("hello");
    var pos = 0;
    var id = setInterval(frame, 75);
    function frame() {
        if(pos == 15){
            clearInterval(id);
        }
        else {
            pos++;
            elem.style.top = pos + '%';
            elem.style.bottom = pos + "%";

        }
    }




})