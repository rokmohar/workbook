var socket = io('http://192.168.27.128:1234');

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
        socket.emit("status", status.value);

        error.innerHTML = "";
        status.value = "";
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

function addPost(data) {
    var post = document.createElement("article");
    post.className = "widget-post";
    post.innerHTML = "<div class=\"widget-post-img\">" +
        "<a href=\"profile.html\"><img src=\"./images/avatars/simpson.jpg\" width=\"60\" height=\"60\" /></a>" +
        "</div>" +
        "<div class=\"widget-post-container\">" +
        "<div class=\"widget-post-title\">" +
        "<a href=\"profile.html\">Rok Mohar</a> shared a <a href=\"#\">" +
        data.type +
        "</a>." +
        "</div>" +
        "<div class=\"widget-post-content\">" +
        data.content +
        "</div>" +
        "</div>";

    var wall = document.getElementById("wall");

    if (wall) {
        wall.insertBefore(post, wall.firstChild);
    }
}

socket.on("post", function(post) {
    addPost(post);
});

socket.on("posts", function(posts) {
    for (var i = 0; i < posts.length; i++) {
        addPost(posts[i]);
    }
});

socket.on("stats", function(data) {
    console.log(data);

    var numUsers = document.getElementById("users-count");
    var numAdmins = document.getElementById("admins-count");
    var numReports = document.getElementById("reports-count");

    if (numUsers) {
        numUsers.innerHTML = data.users;
    }

    if (numAdmins) {
        numAdmins.innerHTML = data.admins;
    }

    if (numReports) {
        numReports.innerHTML = data.reports;
    }
});