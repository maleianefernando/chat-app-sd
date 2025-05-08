const Redis = require('ioredis');
const redis = new Redis();

const io = require('socket.io')(3000, {
    cors: {
        origin: "*"
    }
});

io.on('connection', (socket) => {
    console.log("Conectado no socket: " + socket.id)
})

redis.psubscribe("laravel_database_private-chat-app", (err, count) => {
    console.log(count);
});

redis.on('pmessage', (pattern, channel, message) => {
    console.log(`Canal: ${channel}\n Mensagem: ${message}`);
    const data = JSON.parse(message)
    console.log(data)

    io.emit(channel, data);
});

redis.on('messageBuffer', function (channel, message) {
    // Both `channel` and `message` are buffers.
    // console.log(message)
  });
