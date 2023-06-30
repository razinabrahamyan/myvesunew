var fs = require( 'fs' );
var app = require('express')();
var https        = require('https');
var server = https.createServer({
    key: fs.readFileSync('/etc/letsencrypt/live/myvesu.aurosystem.com/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/myvesu.aurosystem.com/fullchain.pem'),
},app);
server.listen(8443);
var io = require('socket.io').listen(server);
io.sockets.on('connection', function (socket) {
    console.log('gfgfggfgfgfg')
    socket.on('chat.message', function (message,chat_name) {
        io.emit(chat_name, message);
    })
});
