<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
    public static function fetchById(string $id)
    {
        $db = new DataSource();
        $result = $db->selectOne(
            'select * from users where id = :id',
            [':id' => $id],
            DataSource::CLS,
            UserModel::class
        );
        return $result;
    }
}
