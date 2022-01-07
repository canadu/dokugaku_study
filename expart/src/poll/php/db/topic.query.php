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
            'select * from topics where user_id = :id and del_flg != 1;',
            [':id' => $user->id],
            DataSource::CLS,
            TopicModel::class
        );
        return $result;
    }
}
