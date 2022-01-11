<?php

namespace controller\home;

use db\TopicQuery;

function get(): void
{
    $topics = TopicQuery::fetchPublishedTopics();
    \view\home\index($topics);
}
