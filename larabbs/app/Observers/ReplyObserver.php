<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        //评论通知
        $reply->topic->user->notifyReplyToDB(new TopicReplied($reply));
    }
}
