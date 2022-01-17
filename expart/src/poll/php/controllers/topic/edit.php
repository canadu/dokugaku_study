<?php

namespace controller\topic\edit;

use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get() : void
{
    Auth::requireLogin();

    //セッションからデータを取得
    $topic = TopicModel::getSessionAndFlush();

    if (!empty($topic)) {
        \view\topic\edit\index(unserialize($topic), true);
        return;
    }

    $topic = new TopicModel();
    $topic->id = get_param('topic_id', null, false);
    $user = unserialize(UserModel::getSession());
    Auth::requirePermission($topic->id, $user);
    $fetchedTopic = TopicQuery::fetchById($topic);
    \view\topic\edit\index($fetchedTopic, true);
}

function post() : void
{
    Auth::requireLogin();

    $topic = new TopicModel();
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    $user = unserialize(UserModel::getSession());
    Auth::requirePermission($topic->id, $user);
    $is_success = false;
    
    try {
        $is_success = TopicQuery::update($topic);
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
        //エラーになっても入力内容をセッションに保存する
        TopicModel::setSession(serialize($topic));
        redirect(GO_REFERER);
    }
}
