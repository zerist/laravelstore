<?php

namespace App\Observers;

use App\Models\Topic;

class TopicOberver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->except = make_except($topic->body);
    }
}
