<?php

namespace controller\topic\detail;

use db\CommentQuery;
use db\DataSource;
use lib\Msg;
use lib\Auth;
use db\TopicQuery;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;
use Throwable;

function get(): void
{
    $topic = new TopicModel();
    $topic->id = get_param('topic_id', null, false);

    //viewのインクリメント
    TopicQuery::incrementViewCount($topic);

    //ユーザーに紐づくトピックを取得する
    $fetchedTopic = TopicQuery::fetchByID($topic);

    //ユーザーが投稿したトピックのコメントを取得
    $comments = CommentQuery::fetchByTopicId($topic);

    if (empty($fetchedTopic) || !$fetchedTopic->published) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }
    \view\topic\detail\index($fetchedTopic, $comments);
}

function post(): void
{
    Auth::requireLogin();
    $comment = new CommentModel();
    $comment->topic_id = get_param('topic_id', null);
    $comment->agree = get_param('agree', null);
    $comment->body = get_param('body', null);

    $user = unserialize(UserModel::getSession());
    $comment->user_id = $user->id;
    $is_success = false;
    $db = null;
    try {
        $db = new DataSource();
        $db->begin();

        $is_success = TopicQuery::incrementLikesOrDislikes($comment);
        if ($is_success && !empty($comment->body)) {
            $is_success = CommentQuery::insert($comment);
        }
    } catch (Throwable  $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        $is_success = false;
    } finally {
        if ($is_success) {
            $db->commit();
            Msg::push(Msg::INFO, 'コメントの登録に成功しました。');
        } else {
            $db->rollback();
            Msg::push(Msg::ERROR, 'コメントの登録に失敗しました。');
        }
    }
    redirect('topic\detail?topic_id=' . $comment->topic_id);
}
