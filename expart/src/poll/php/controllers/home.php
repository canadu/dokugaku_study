<?php

namespace controller\home;

use db\TopicQuery;

function get(): void
{
    //modelからデータを取得する
    $topics = TopicQuery::fetchPublishedTopics();
    //データをviewに引き渡し
    \view\home\index($topics);
}
