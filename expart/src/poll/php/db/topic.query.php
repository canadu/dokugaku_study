<?php

namespace db;

use db\DataSource;
use model\TopicModel;

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
}
