const Redis = require('ioredis');
const redis = new Redis();

redis.set('name', 'philip');
console.log(redis.get('name'));