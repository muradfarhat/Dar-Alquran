let cookieName = "stPageNum";

(function setCookie() {
    let ca = localStorage.getItem(cookieName);
    if(ca == null){
        localStorage.setItem(cookieName,'1');
        display();
    }
    else if(ca == '1'){
        display();
    }
    else if(ca == '2'){
        display2();
    }
    else if(ca == '4'){
        display6();
    }
}());


function display() {
    document.getElementById("content").style.display = "";
    document.getElementById("profile").style.display = "none";
    document.getElementById("pass").style.display = "none";
    //document.getElementById("chart").style.display = "none";

    localStorage.setItem(cookieName,'1');

}
function display2() {
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "";
    document.getElementById("pass").style.display = "none";
    //document.getElementById("chart").style.display = "none";

    localStorage.setItem(cookieName,'2');
}
/*function display5 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("pass").style.display = "none";
    document.getElementById("chart").style.display = "";

    localStorage.setItem(cookieName,'3');
}*/

function display6 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("pass").style.display = "";
    //document.getElementById("chart").style.display = "none";

    localStorage.setItem(cookieName,'4');
}
function signOut(){
    localStorage.removeItem(cookieName);
}
