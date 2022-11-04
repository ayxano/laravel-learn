<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;
use Elasticsearch;
class IndexPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes posts to ElasticSearch';

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
    public function handle()
    {
        $posts = BlogPost::all();
        foreach ($posts as $post) {
            try {
                Elasticsearch::index([
                    'id' => $post->id,
                    'index' => 'posts',
                    'body' => $post->toArray()
                ]);
            } catch (\Exception $e) {
                $this->info($e->getMessage());
            }
        }
        
        $this->info("Posts were successfully indexed");
    }
}
