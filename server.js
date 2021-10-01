var socket = require('socket.io');
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;

server.listen(port, function () {
    console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {

    socket.on('new_message', function (data) {
        console.log(data);
        io.sockets.emit('new_message', {
            'msgtxt': data.msgtxt
        });
    });

});
