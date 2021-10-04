var socket = require('socket.io');
var express = require('express');
var cors = require('cors');
var app = express();
app.use(cors);
var server = require('http').createServer(app);
//var io = socket.listen(server);
const { Server } = require('socket.io');
const io = new Server(server); 
var port = process.env.PORT || 3000;
server.listen(port, function () {
    console.log('Server listening at port %d', port);
});

io.on('connection', function (socket) {
   console.log(socket)
    socket.on('new_message', function (data) {
        console.log(data);
        io.sockets.emit('new_message', {
            'msgtxt': data.msgtxt
        });
    });

});
