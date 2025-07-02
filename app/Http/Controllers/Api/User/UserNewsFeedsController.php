<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NewsFeed;

class UserNewsFeedsController extends Controller
{
    public function __construct(private NewsFeed $news_feeds){}

    public function view(Request $request){
        $news_feeds = $this->news_feeds
        ->orderByDesc('id')
        ->with('user')
        ->get()
        ->map(function($item){
            return [
                'id' => $item->id,
                'content' => $item->content,
                'image_link' => $item->image_link,
                'video_link' => $item->video_link,
                'user_image' => $item->avatar_image_link,
                'name' => $item->name,
                'post_date' => $item->created_at,
            ];
        });

        return response()->json([
            'news_feeds' => $news_feeds,
        ]);
    }
}
