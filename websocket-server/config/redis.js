require('dotenv').config();

const redisCredentials = {
    url: process.env.REDIS_URL
}

module.exports = redisCredentials;
