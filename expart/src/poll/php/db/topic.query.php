<?php

namespace db;

use db\DataSource;
use model\TopicModel;
use model\UserModel;


class TopicQuery
{
    public static function fetchByUserID($user)
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

    public static function fetchById($topic)
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

    public static function fetchPublishedTopics()
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
                ORDER BY t.id DESC';
        $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);
        return $result;
    }

    public static function incrementViewCount($topic)
    {
        if (!$topic->isValidId()) {
            return false;
        }
        $db = new DataSource;
        $sql = 'UPDATE topics SET views = views + 1 WHERE id = :id';
        return $db->execute($sql, [':id' => $topic->id]);
    }

    public static function isUserOwnTopic($topic_id, $user)
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
}
