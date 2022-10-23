<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() // Receiver. For example: This is radio listener
    {
        ini_set('default_socket_timeout', -1); // add this to prevent connection timeouts
        Redis::subscribe(['test-channel'], function ($message, $channel) {
            echo 'Channel: ' . $channel . PHP_EOL;
            echo 'Message: ' . $message . PHP_EOL . PHP_EOL;
        });

        /* OR use Wildcard Subscriptions 
        Redis::psubscribe(['*'], function ($message, $channel) {
            echo 'Channel: ' . $channel . PHP_EOL;
            echo 'Message: ' . $message . PHP_EOL . PHP_EOL;
        });
        
        Redis::psubscribe(['users.*'], function ($message, $channel) {
            echo 'Channel: ' . $channel . PHP_EOL;
            echo 'Message: ' . $message . PHP_EOL . PHP_EOL;
        });
        */
    }
}
