<?php

namespace db;

use db\DataSource;
use model\TopicModel;
use model\UserModel;
use model\CommentModel;

class TopicQuery
{
    /**
     * ユーザーが投稿したトピックを全件取得
     * @param UserModel $user
     * @return array<mixed> | bool 
     */
    public static function fetchByUserID(UserModel $user) : array | bool
    {
        if (!$user->isValidId()) {
            return false;
        }
        $db = new DataSource();
        $result = $db->select(
            'SELECT * FROM topics WHERE user_id = :id AND del_flg != 1 ORDER BY id DESC;',
            [':id' => $user->id],
            DataSource::CLS,
            TopicModel::class
        );
        return $result;
    }

    /**
     * ユーザーが投稿したトピックの中から指定のトピックを取得
     * @param TopicModel $topic
     * @return mixed
     *
     */ 
    public static function fetchById(TopicModel $topic) : mixed
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource();
        $sql = 'SELECT 
                    t.*,
                    u.nickname 
                FROM 
                    topics t 
                INNER JOIN 
                    users u ON 
                    t.user_id = u.id 
                WHERE t.id = :id 
                    AND t.del_flg != 1 
                    AND u.del_flg !=1 
                ORDER BY t.id DESC';
        $result = $db->selectOne($sql, [':id' => $topic->id], DataSource::CLS, TopicModel::class);
        return $result;
    }

    /**
     * ユーザーが投稿したトピックの中から公開済みのトピックを取得する
     * @return array<mixed>
     */
    public static function fetchPublishedTopics() : array
    {
        $db = new DataSource();
        $sql = 'SELECT 
                    t.*,
                    u.nickname
                FROM topics t
                INNER JOIN 
                    users u ON 
                    t.user_id = u.id 
                WHERE t.del_flg != 1 
                    AND u.del_flg !=1 
                    AND t.published != 0 
                ORDER BY t.id DESC';
        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);
        return $result;
    }

    /**
     * 閲覧数をインクリメントする
     * @param TopicModel $topic
     * @return bool
     */
    public static function incrementViewCount(TopicModel $topic) : bool
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource();
        $sql = 'UPDATE topics SET views = views + 1 WHERE id = :id';
        return $db->execute($sql, [':id' => $topic->id]);
    }

    /**
     * ユーザーに紐づいたトピックの件数を取得
     * @param int $topic_id
     * @param UserModel $user
     * @return bool
     */
    public static function isUserOwnTopic(int $topic_id, UserModel $user) : bool
    {
        if (!(TopicModel::validateId($topic_id) && $user->isValidId())) {
            return false;
        }
        $db = new DataSource();
        $sql = 'SELECT 
                count(1) as count
                FROM 
                    topics t 
                WHERE t.id = :topic_id 
                    AND t.user_id = :user_id
                    AND t.del_flg !=1';
        $result = $db->selectOne($sql, [':topic_id' => $topic_id, ':user_id' => $user->id]);
        if (!empty($result) && $result['count'] != 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * トピックを編集する
     * @param TopicModel $topic
     * @return bool
     */
    public static function update(TopicModel $topic) : bool
    {
        //値のチェック
        if (!($topic->isValidId() * $topic->isValidTitle() * $topic->isValidPublished())) {
            return false;
        }

        $db = new DataSource();
        $sql = 'UPDATE topics SET published = :published, title = :title WHERE id = :id';
        return $db->execute($sql, [
            ':published' => $topic->published,
            ':title' => $topic->title,
            ':id' => $topic->id,
        ]);
    }

    /**
     * トピックを登録する
     * @param TopicModel $topic
     * @param UserModel $user
     * @return bool
     */
    public static function insert(TopicModel $topic, UserModel $user) : bool
    {
        //値のチェック
        if (!($user->isValidId() * $topic->isValidTitle() * $topic->isValidPublished())) {
            return false;
        }

        $db = new DataSource();
        $sql = 'INSERT into topics(title, published, user_id) VALUES (:title, :published, :user_id)';
        return $db->execute($sql, [
            ':title' => $topic->title,
            ':published' => $topic->published,
            ':user_id' => $user->id,
        ]);
    }

    /**
     * トピックの賛成、反対を更新する
     * @param CommentModel $comment
     * @return bool
     */
    public static function incrementLikesOrDislikes(CommentModel $comment) : bool
    {
        //値のチェック
        if (!($comment->isValidTopicId() * $comment->isValidAgree())) {
            return false;
        }
        $db = new DataSource();
        if ($comment->agree) {
            $sql = 'UPDATE topics SET likes = likes + 1 WHERE id = :topic_id';
        } else {
            $sql = 'UPDATE topics SET dislikes = likes + 1 WHERE id = :topic_id';
        }
        return $db->execute($sql, [':topic_id' => $comment->topic_id,]);
    }
}
