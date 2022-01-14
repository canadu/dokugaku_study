<?php

namespace db;

use db\DataSource;
use model\UserModel;

class UserQuery
{
    //ユーザー情報を取得
    public static function fetchById(string $id)
    {
        $db = new DataSource();
        $result = $db->selectOne(
            'SELECT * FROM users WHERE id = :id',
            [':id' => $id],
            DataSource::CLS,
            UserModel::class
        );
        return $result;
    }

    //ユーザー情報を登録
    public static function insert($user)
    {
        $db = new DataSource;
        $sql = 'INSERT INTO users(id,pwd,nickname) VALUES (:id, :pwd, :nickname)';
        //ソルトもpassword_hash関数が自動的に生成される
        $pwd = password_hash($user->pwd, PASSWORD_DEFAULT);
        return $db->execute($sql, [
            ':id' => $user->id,
            ':pwd' => $pwd,
            ':nickname' => $user->nickname,
        ]);
    }
}
