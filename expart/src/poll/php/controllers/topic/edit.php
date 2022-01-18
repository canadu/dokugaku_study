<?php

namespace controller\topic\edit;

use db\CommentQuery;
use db\TopicQuery;
use lib\Auth;
use lib\Msg;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get(): void
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

function post(): void
{
    Auth::requireLogin();

    $topic = new TopicModel();
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);

    $user = unserialize(UserModel::getSession());
    Auth::requirePermission($topic->id, $user);
    $is_success = false;

    $registerMode = get_param('register', null);
    $deleteMode = get_param('delete', null);
    $msg = '';
    try {
        if (!is_null($registerMode)) {
            $msg = '更新';
            $is_success = TopicQuery::update($topic);
        } elseif (!is_null($deleteMode)) {
            $msg = '削除';
            $is_success = TopicQuery::delete($topic);
            if ($is_success) {
                //トピックに基づくコメントも削除する
                $is_success = CommentQuery::delete($topic);
            }
        }
    } catch (Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    }

    if ($is_success) {
        Msg::push(Msg::INFO, "トピックの{$msg}に成功しました。");
        redirect('topic/archive');
    } else {
        Msg::push(Msg::ERROR, "トピックの{$msg}に失敗しました。");
        //エラーになっても入力内容をセッションに保存する
        TopicModel::setSession(serialize($topic));
        redirect(GO_REFERER);
    }
}
