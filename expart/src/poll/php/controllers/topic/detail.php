<?php

namespace controller\topic\detail;

use db\CommentQuery;
use lib\Msg;
use db\TopicQuery;
use model\TopicModel;

function get()
{
    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null, false);

    //viewのインクリメント
    TopicQuery::incrementViewCount($topic);
    
    //ユーザーに紐づくトピックを取得する
    $fetchedTopic = TopicQuery::fetchByID($topic);

    //ユーザーが投稿したトピックのコメントを取得
    $comments = CommentQuery::fetchByTopicId($topic);

    if ($fetchedTopic === false) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }
    \view\topic\detail\index($fetchedTopic, $comments);
}
