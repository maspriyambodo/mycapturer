var cors = require('cors');
var socket = require('socket.io')(server, {
    wsEngine: require("eiows").Server,
    transports: ["websocket", "polling"],
    cors: {
        origin: ["https://mc.alfabet.io", "https://mc.sertifikasiku.com", "http://localhost"],
	default:"https:mc.sertifikasiku.com",
        methods: ["GET", "POST"]
    }
});
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = socket.listen(server);
var port = 3000;

server.listen(port, function () {
    console.log('Server listening at port %d', port);
});


io.on('connection', function (socket) {

    socket.on('new_message', function (data) {
	if(!data.username){
		return false;
	} else{
        	return io.sockets.emit('new_message', {
			'username': data.username,
			'fullname': data.fullname,
			'key': data.key,
			'msgtxt': data.msgtxt,
			'avatar': data.avatar,
			'name_role': data.role_name,
			'id_user': data.id_user,
			'id_role': data.id_role,
			'chat_id': data.id_chat,
			'tym_chat': data.tym_chat
        	});
	}
    });

   socket.on('kick_user', function(data){
	return io.sockets.emit(data.key, {
		'uname': data.uname,
		'chat_id': data.chat_id,
		'user_id': data.user_id,
		'msg': data.msg,
		'category': 1
	});
   });

  socket.on('warning_user', function(data){
        return io.sockets.emit(data.key, {
                'uname': data.uname,
                'chat_id': data.chat_id,
                'user_id': data.user_id,
                'msg': data.msg,
		'category': 2
        });
   });

  socket.on('absensi', function(data){
        return io.sockets.emit('absensi', {

        });
   });

});
