/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */
function reload() {
    window.location.reload(true);
    document.cookie = "loadOnce=true";
}

function loginUser() { //not used at the moment
    var p = document.getElementById("pass").value;
    var length = p.length;
    
     if (length <= 11) {
        alert("Password must be more than 12 characters");
        document.getElementById("login").action = "";
        return;
    }
    
}

function savePass() { 
    var p = document.getElementById("password").value;
    var cp = document.getElementById("cpassword").value;
    var length = p.length;
    
    if (length <= 11) {
        alert("Password must be more than 12 characters");
        document.getElementById("registration").action = "";
        return;
    }
    if (p !== cp) {
        alert("Password does not match.");
        document.getElementById("registration").action = "";
        return;
    }
    
}

function showPass() {
    var x = document.getElementById("passwordInput");
    if (x.type == "password") {
        x.type = "text";
    }
    else {
        x.type = "password";
    }
}




