<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Image;

use App\Models\NewsFeed;

class NewsFeedsController extends Controller
{
    use Image;
    public function __construct(private NewsFeed $news_feeds){}

    public function view(Request $request){
        $news_feeds = $this->news_feeds
        ->where('user_id', $request->user()->id)
        ->get();

        return response()->json([
            'news_feeds' => $news_feeds
        ]);
    }

    public function news_feeds(Request $request, $id){
        $news_feeds = $this->news_feeds
        ->where('user_id', $request->user()->id)
        ->where('id', $id)
        ->first();

        return response()->json([
            'news_feeds' => $news_feeds
        ]);
    }

    public function create(Request $request){
        $newsRequest['user_id'] = $request->user()->id;
        if (!empty($request->image)) {
            $newsRequest['image'] = $this->storeBase64Image($request->image, 'newsfeeds/images');
        }
        if (!empty($request->video)) {
            $newsRequest['video'] = $this->upload_image($request, 'video', 'newsfeeds/videos');
        }
        if (!empty($request->content)) {
            $newsRequest['content'] = $request->content;
        }
        $this->news_feeds
        ->create($newsRequest);

        return response()->json([
            'success' => 'You add data success'
        ]);
    }

    public function modify(Request $request, $id){
        
        $news_feeds = $this->news_feeds
        ->where('id', $id)
        ->first();
        if (!empty($request->image)) {
            $newsRequest['image'] = $this->storeBase64Image($request->image, 'newsfeeds/image');
            $this->deleteImage($news_feeds->image);
        }
        if (!empty($request->video)) {
            $newsRequest['video'] = $this->update_image($request, $news_feeds->video, 'video', 'newsfeeds/videos');
        }
        if (!empty($request->content)) {
            $newsRequest['content'] = $request->content;
        }
        $news_feeds->update($newsRequest);

        return response()->json([
            'success' => 'You update data success'
        ]);
    }

    public function delete(Request $request, $id){
        $news_feeds = $this->news_feeds
        ->where('id', $id)
        ->first();
        $this->deleteImage($news_feeds->image);
        $this->deleteImage($news_feeds->video);
        $news_feeds->delete();

        return response()->json([
            'success' => 'You delete data success'
        ]);
    }
}
