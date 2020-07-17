<?php

namespace App\Observers;

use App\Models\Topic;

class TopicOberver
{
    public function saving(Topic $topic)
    {
        $topic->except = make_except($topic->body);
    }
}
