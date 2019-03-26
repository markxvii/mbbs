<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ReplyRequest;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Transformers\ReplyTransformer;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Reply $reply)
    {
        if (Topic::find($request->topic_id)) {
            $reply->topic_id=$request->topic_id;
        }else{
            return $this->response->error('没有找到指定的帖子', 404);
        }
        $reply->user_id=$this->user()->id;
        $reply->content=$request->content;
        $reply->save();
        return $this->response->item($reply, new ReplyTransformer())->setStatusCode(201);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();
        return $this->response->noContent();
    }

    public function index(Topic $topic)
    {
        $replies=$topic->replies()->get();
        return $this->response->collection($replies,new ReplyTransformer());
    }

    public function userIndex(User $user)
    {
        $replies = $user->replies()->get();
        return $this->response->collection($replies, new ReplyTransformer());
    }
}
