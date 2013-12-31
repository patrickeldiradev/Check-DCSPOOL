<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessStory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $storyId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($storyId)
    {
        $this->storyId = $storyId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', "https://hacker-news.firebaseio.com/v0/item/{$this->storyId}.json?print=pretty");
        $story = json_decode($response->getBody()->getContents(), true);

        $existingStory = \App\Models\Story::where('id', $this->storyId)->first();
        if (!$existingStory) {
            \App\Models\Story::create([
                'id' => $this->storyId,
            ]);
        }
    }
}
