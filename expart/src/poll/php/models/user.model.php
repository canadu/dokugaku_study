<?php

namespace model;

use lib\Msg;

//AbstractModelを継承
class UserModel extends AbstractModel
{
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    //なにか特定のメソッドを通じて値を取得するようなものにアンダースコアをつける！
    protected static $SESSION_NAME = '_user';

    public function isValidId()
    {
        return static::validateId($this->id);
    }

    public static function validateId($val)
    {
        $res = true;
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
            $res = false;
        } else {
            if (strlen($val) > 10) {
                Msg::push(Msg::ERROR, 'ユーザーIDは10桁以下で入力してください。');
                $res = false;
            }
            if (preg_match("/^[a-zA-Z0-9]+$/", $val)) {
                Msg::push(Msg::ERROR, 'ユーザーIDは半角英数字で入力してください');
                $res = false;
            }
        }
        return $res;
    }
}
