<?php

namespace App\Http\Controllers;

use App\Console\Commands\FetchHackerNewsData;
use Illuminate\Http\Request;

class HackerNewsController extends Controller
{
    public function fetchHackerNewsData()
    {
        FetchHackerNewsData::dispatch();
        return response()->json([
            'message' => 'Hacker News data fetching initiated.'
        ]);
    }
}
