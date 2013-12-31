<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Story;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class HackerNewsService
{
    public function fetchTopStories()
    {
        $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');
        $storyIds = $response->json();

        foreach ($storyIds as $storyId) {
            $this->fetchAndStoreStory($storyId);
        }
    }

    protected function fetchAndStoreStory($storyId)
    {
        $storyData = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json")->json();
        $story = Story::updateOrCreate(
            ['id' => $storyId],
            [
                'title' => $storyData['title'],
                'by' => $storyData['by'],
                'score' => $storyData['score'],
                'url' => $storyData['url'] ?? null,
            ]
        );

        if (isset($storyData['kids'])) {
            foreach ($storyData['kids'] as $commentId) {
                $this->fetchAndStoreComment($commentId, $story->id);
            }
        }
    }

    protected function fetchAndStoreComment($commentId, $storyId)
    {
        $commentData = Http::get("https://hacker-news.firebaseio.com/v0/item/{$commentId}.json")->json();

        if ($commentData && isset($commentData['text'])) {
            Comment::updateOrCreate(
                ['id' => $commentId],
                [
                    'text' => $commentData['text'],
                    'by' => $commentData['by'],
                    'parent' => $storyId,
                ]
            );

            if (isset($commentData['kids'])) {
                foreach ($commentData['kids'] as $childCommentId) {
                    $this->fetchAndStoreComment($childCommentId, $storyId); // Recursively fetch and store child comments
                }
            }
        }
    }
}
