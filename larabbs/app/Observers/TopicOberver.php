<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

class TopicOberver
{
    public function saving(Topic $topic)
    {
        //content安全转义
        $topic->body = clean($topic->body, 'user_topic_body');

        //生成内容摘要
        $topic->except = make_except($topic->body);

        //生成slug字段
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}
