<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

// This class was never used
class RedisUserStatusListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:user-offline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to redis for user offline status';

    /**
     * Execute the console command.
     */
    // This class was never used
    public function handle()
    {
        Redis::subscribe(['user-offline-channel'], function ($message) {
            $data = json_decode($message, true);
            Log::info("User offline: " . $data['user_id']);
        });

    }
}
