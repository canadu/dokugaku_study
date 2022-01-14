<?php

namespace controller\topic\edit;

use db\TopicQuery;
use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get()
{
    Auth::requireLogin();
    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null, false);
    $user = unserialize(UserModel::getSession());
    Auth::requirePermission($topic->id, $user);
    $fetchedTopic = TopicQuery::fetchById($topic);
    \view\topic\edit\index($fetchedTopic);
}
