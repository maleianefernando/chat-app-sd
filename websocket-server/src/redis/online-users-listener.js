const Redis = require("ioredis");
const io = require("../web-socket");
const redisCredentials = require("../../config/redis");

const redis = new Redis(redisCredentials.url);
const onlineUserEvent = "online_users";

function execSocketListener() {
    console.log('Online Users Listener');
  io.on("connection", (socket) => {
    console.log("Connected at socket: " + socket.id);

    const userId = socket.handshake.query.user_id;

    if (userId) {
      redis.sadd(onlineUserEvent, userId);
      emitOnlineUsers();

      socket.on("disconnect", async () => {
        await redis.srem(onlineUserEvent, userId);
        emitOnlineUsers();
      });
    }
  });

  async function emitOnlineUsers() {
    const onlineUsers = await redis.smembers(onlineUserEvent);
    console.log(onlineUsers);
    io.emit(onlineUserEvent, onlineUsers);
  }
}
 module.exports = execSocketListener;