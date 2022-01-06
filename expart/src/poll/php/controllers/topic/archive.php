<?php

namespace controller\topic\archive;

use db\TopicQuery;
use model\UserModel;

function get()
{

    $user = unserialize(UserModel::getSession());
    $topics = TopicQuery::fetchByUserID($user);
    echo '<pre>', print_r($topics), '</pre>';
}
