<?php

namespace App\Console\Commands;

use App\Models\Story;
use App\Services\HackerNewsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchHackerNewsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:hackernews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from HackerNews';
    protected $hackerNewsService;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->hackerNewsService = resolve(HackerNewsService::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("Maintain");
        $this->hackerNewsService->fetchTopStories();
        $this->info('Successfully fetched and stored HackerNews data.');
    }
}
