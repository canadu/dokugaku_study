<?php

namespace db;

use db\DataSource;
use model\CommentModel;

class CommentQuery
{
    public static function fetchByTopicId($topic)
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource();
        $sql = 'SELECT
                    c.*,u.nickname
                FROM comments c
                INNER JOIN users u
                ON c.user_id = u.id
                WHERE c.topic_id = :id
                    AND c.body != ""
                    AND c.del_flg != 1
                    AND u.del_flg != 1
                ORDER BY c.id DESC';
        $result = $db->select($sql, [':id' => $topic->id], DataSource::CLS, CommentModel::class);
        return $result;
    }

    public static function insert($comment)
    {
        //値のチェック
        if (!($comment->isValidTopicId() * $comment->isValidBody() * $comment->isValidAgree())) {
            return false;
        }

        $db = new DataSource;
        $sql = 'INSERT into comments(topic_id, agree, body, user_id) VALUES (:topic_id, :agree, :body, :user_id)';
        return $db->execute($sql, [
            ':topic_id' => $comment->topic_id,
            ':agree' => $comment->agree,
            ':body' => $comment->body,
            ':user_id' => $comment->user_id,
        ]);
    }
}
