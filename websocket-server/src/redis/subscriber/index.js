const Redis = require("ioredis");
const redisCredentials = require("../../../config/redis");
const io = require("../../web-socket");

const subscriber = new Redis(redisCredentials.url);
const messageChannel = "laravel_database_private-chat-app";

function execRedisPubSub() {
  console.log("Subscriber");
  
  subscriber.psubscribe(messageChannel, (err, count) => {
    console.log(count);
  });

  subscriber.on("pmessage", (pattern, channel, message) => {
    console.log(`Channel: ${channel}\n Message: ${message}`);
    const data = JSON.parse(message);

    io.emit(channel, data);
  });
}

module.exports = execRedisPubSub;
