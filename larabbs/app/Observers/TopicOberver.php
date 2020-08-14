<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

class TopicOberver
{
    public function saving(Topic $topic)
    {
        //content安全转义
        $topic->body = clean($topic->body, 'user_topic_body');

        //生成内容摘要
        $topic->except = make_except($topic->body);

    }

    public function saved(Topic $topic)
    {
        if ( ! $topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }
}
