<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function get() :void {
        $readFromRedis = Redis::get('name');
        var_dump($readFromRedis);
    }

    public function set() :void {
        $writeToRedis = Redis::set('name', 'Aykhan');
        var_dump($writeToRedis);
    }
    public function setExpiredKey() :void {
        $writeToRedis = Redis::setex('name', 10, 'Aykhan');
        var_dump($writeToRedis);
    }
    public function transaction() {
        Redis::transaction(function ($redis) {
            $redis->incr('user_visits', 1);
            $redis->incr('total_visits', 1);
        });
    }

    public function pipeline() {
        Redis::pipeline(function ($pipe) {
            for ($i = 0; $i < 1000; $i++) {
                $pipe->set("key:$i", $i);
            }
        });
    }

    public function publish() :void { // Sender. For example: This is radio broadcaster
        Redis::publish('test-channel', json_encode([
            'name' => 'Adam Wathan',
            'time' => time()
        ]));
    }
}
