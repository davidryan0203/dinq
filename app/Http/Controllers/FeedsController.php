<?php

namespace App\Http\Controllers;

use App\User;
use App\Orders;
use App\Friends;
use App\CommentsReply;
use App\Comments;
use App\FeedLikes;
use Auth;
use App\Feeds;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FeedsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function feeds()
    {
        return view('feeds');
    }

    public function get(Request $request){
    	$input = $request->all();
    	$friends = Friends::whereIn('status' , ['accepted','following'])->pluck('friend_id');
    	
    	$feeds = Feeds::with('comments','user', 'venue.user')->get();

    	$feedResults = [];
    	foreach ($feeds as $key => $data) {
    		
    		$feedResults[] = [
    			'id' => $data['id'],
    			'likes' => $data['likes'],
    			'created_at' => $data['created_at'],
    			'is_private' => $data['is_private'],
    			'avatar' => $data['author']['image_url'],
    			'media' => $data['media'],
    			'content' => $data['content'],
    			'name' => $data['name'],
    			'feed_type' => $data['feed_type'],
    			'venue_id' => ($data['venue_id'] == 0) ? null : $data['venue_id'],
    			'venue_name' => ($data['venue_id'] == 0) ? null : $data['venue']['user']['name'],
    			'author_id' => $data['author_id'],
    			'author_name' => $data['author']['name'],
                'isLiked' => $data['is_liked'],
    			'comments' => $data['comments']->count(),
    		];
    	}
        return response($feedResults, 200)->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
