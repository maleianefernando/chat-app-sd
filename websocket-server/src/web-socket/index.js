const SocketServer = require("socket.io");

const io = SocketServer(3000, {
  cors: {
    origin: "*",
  },
});

module.exports = io;
