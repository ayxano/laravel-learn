<?php

namespace App\Jobs;

use App\Models\BlogPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class ThrottledMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mail;
    public $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mail, BlogPost $post)
    {
        $this->mail = $mail;
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('mailtrap')->allow(1)->every(12)->then(function () {
            Mail::to('ayxano@gmail.com')->send($this->mail);
        }, function () {
            return $this->release(5);
        });
    }
}
