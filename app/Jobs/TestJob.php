<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 4;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 15;
    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // print_r($this->data); //shows the input for job
        // var_dump($this->attempts()); // shows how many tries for the current job
        // $this->delete(); // deletes job
        // throw new Exception("Something happened!"); failing job example by throwing exception
        // $this->fail(throw new Exception("Happy bi/rthday!")); // makes job to fail, input is optional
        var_dump($this->attempts());
        if($this->attempts() === 5) {
            echo 'Success', PHP_EOL;
            return true;
        }
        throw new Exception("BackOff Exception");
        // return $this->release(1); // it makes job a delay.
        // return true;
        // */
    }
 
    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        echo 'JOB FAILED!!!' . PHP_EOL;
    }
}