var io = require('socket.io')(1234);

var posts = [];
var stats = [3, 3, 3];

setInterval(function() {
    var r = Math.floor(Math.random() * 3);
    stats[r]++;
}, 5000);

io.on('connection', function (socket) {
    socket.emit("posts", posts);
    socket.emit("stats", { users: stats[0], admins: stats[1], reports: stats[2] });

    socket.on("status", function(data) {
        posts.push({
            type: 'post',
            content: data
        });
        socket.emit("post", posts[posts.length - 1]);
    });
});

io.on('connection', function (socket) {
    setInterval(function() {
        socket.emit("stats", { users: stats[0], admins: stats[1], reports: stats[2] });
    }, 5000);
});
