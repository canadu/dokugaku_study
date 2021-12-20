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

    public static function insert($user)
    {
        $db = new DataSource;
        $sql = 'insert into users(id,pwd,nickname) values (:id, :pwd, :nickname)';
        //ソルトもpassword_hash関数が自動的に生成される
        $pwd = password_hash($user->pwd, PASSWORD_DEFAULT);
        return $db->execute($sql, [
            ':id' => $user->id,
            ':pwd' => $user->pwd,
            ':nickname' => $user->nickname,
        ]);
    }
}
