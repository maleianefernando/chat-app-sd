const redisPubSub = require("./src/redis/subscriber/index");
const onlineUsersListener = require("./src/redis/online-users-listener");

(() => {
  redisPubSub();
  onlineUsersListener();
})();
