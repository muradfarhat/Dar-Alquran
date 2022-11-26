let Name = "teacherNum";

(function setCookie() {
    let ca = localStorage.getItem(Name);
    if(ca == null){
        localStorage.setItem(Name,'1');
        display();
    }
    else if(ca == '1'){
        display();
    }
    else if(ca == '2'){
        display2();
    }
    else if(ca == '3'){
        display3();
    }
    else if(ca == '4'){
        display4();
    }
    else if(ca == '5'){
        display5();
    }
    else if(ca == '6'){
        display6();
    }
}());


function display() {
    document.getElementById("content").style.display = "";
    document.getElementById("profile").style.display = "none";
    document.getElementById("circles").style.display = "none";
    document.getElementById("news").style.display = "none";
    document.getElementById("Occasions").style.display = "none";
    document.getElementById("pass").style.display = "none";

    localStorage.setItem(Name,'1');

}
function display2() {
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "";
    document.getElementById("circles").style.display = "none";
    document.getElementById("news").style.display = "none";
    document.getElementById("Occasions").style.display = "none";
    document.getElementById("pass").style.display = "none";

    localStorage.setItem(Name,'2');
}
function display3 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("circles").style.display = "";
    document.getElementById("news").style.display = "none";
    document.getElementById("Occasions").style.display = "none";
    document.getElementById("pass").style.display = "none";

    localStorage.setItem(Name,'3');
}
function display4 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("circles").style.display = "none";
    document.getElementById("news").style.display = "";
    document.getElementById("Occasions").style.display = "none";
    document.getElementById("pass").style.display = "none";

    localStorage.setItem(Name,'4');
}
function display5 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("circles").style.display = "none";
    document.getElementById("news").style.display = "none";
    document.getElementById("Occasions").style.display = "";
    document.getElementById("pass").style.display = "none";

    localStorage.setItem(Name,'5');
}
function display6 (){
    document.getElementById("content").style.display = "none";
    document.getElementById("profile").style.display = "none";
    document.getElementById("circles").style.display = "none";
    document.getElementById("news").style.display = "none";
    document.getElementById("Occasions").style.display = "none";
    document.getElementById("pass").style.display = "";

    localStorage.setItem(Name,'6');
}
function signOut(){
    localStorage.removeItem(Name);
}

