const Redis = require("ioredis");
const SocketServer = require("socket.io");

const subscriber = new Redis({
  host: "localhost",
  port: "6379",
});

const redis = new Redis({
  host: "localhost",
  port: "6379",
});

const io = SocketServer(3000, {
  cors: {
    origin: "*",
  },
});

const onlineUserEvent = "online_users";
const messageChannel = "laravel_database_private-chat-app";

io.on("connection", (socket) => {
  console.log("Connected at socket: " + socket.id);

  const userId = socket.handshake.query.user_id;

  if (userId) {
    redis.sadd(onlineUserEvent, userId);
    emitOnlineUsers();

    socket.on("disconnect", async () => {
    //   redis.publish("user-offline", JSON.stringify({ user_id: userId }));
      await redis.srem(onlineUserEvent, userId);
      emitOnlineUsers();
    });
  }
});

subscriber.psubscribe(messageChannel, (err, count) => {
  console.log(count);
});

subscriber.on("pmessage", (pattern, channel, message) => {
  console.log(`Channel: ${channel}\n Message: ${message}`);
  const data = JSON.parse(message);

  io.emit(channel, data);
});

async function emitOnlineUsers() {
  const onlineUsers = await redis.smembers(onlineUserEvent);
  console.log(onlineUsers);
  io.emit(onlineUserEvent, onlineUsers);
}
