document.addEventListener("DOMContentLoaded", function() {
    var send = document.getElementById("send");
    if (send) {
        send.addEventListener("click", sendStatus);
    }

    var login = document.getElementById("login");
    if (login) {
        login.addEventListener("click", checkLogin);
    }
});

function sendStatus(event) {
    event.preventDefault();
    var status = document.getElementById("status");
    var error = document.getElementById("error");
    if (!status.value.length) {
        error.innerHTML = "Status must contain some text";
    }
    else {
        error.innerHTML = "";
        var wall = document.getElementById("wall");
        var post = "<article class=\"widget-post\">" +
            "<div class=\"widget-post-img\">" +
            "<a href=\"profile.html\"><img src=\"./images/avatars/simpson.jpg\" width=\"60\" height=\"60\" /></a>" +
            "</div>" +
            "<div class=\"widget-post-container\">" +
            "<div class=\"widget-post-title\">" +
            "<a href=\"profile.html\">Rok Mohar</a> shared a <a href=\"#\">post</a>." +
            "</div>" +
            "<div class=\"widget-post-content\">" +
            status.value +
            "</div>" +
            "</div>" +
            "</article>";

        status.value = '';
        wall.innerHTML = post + wall.innerHTML;
    }
}

function checkLogin(event) {
    event.preventDefault();
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var error = document.getElementById("error");

    if (!email.value.length) {
        error.innerHTML = 'E-mail address is required';
    }
    else if (!password.value.length) {
        error.innerHTML = 'Password is required';
    }
    else if (email.value != 'rok.mohar@gmail.com' || password.value != '123456') {
        error.innerHTML = 'E-mail address or password is incorrect';
    }
    else {
        window.location = 'index.html';
    }
}
