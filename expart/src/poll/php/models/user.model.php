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
    protected static mixed $SESSION_NAME = '_user';
    /**
     * ユーザーIDの入力チェックの結果を返す
     * @return bool
    */
    public function isValidId(): bool
    {
        return static::validateId($this->id);
    }
    /**
     *ユーザーIDのチェック
     *@param string|null $val
     *@return bool
    */
    public static function validateId(string | null $val): bool
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
            if (!is_alnum($val)) {
                Msg::push(Msg::ERROR, 'ユーザーIDは半角英数字で入力してください');
                $res = false;
            }
        }
        return $res;
    }
    /**
     *ユーザーパスワードの入力チェックの結果を返す
     * @return bool
    */
    public function isValidPwd(): bool
    {
        return static::validatePwd($this->pwd);
    }
    /**
     *ユーザーパスワードのチェック
     *@param string|null $val
     *@return bool
    */
    public static function validatePwd(string | null $val): bool
    {
        $res = true;
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            $res = false;
        } else {
            if (strlen($val) < 4) {
                Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
                $res = false;
            }
            if (!is_alnum($val)) {
                Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
                $res = false;
            }
        }
        return $res;
    }
    /*
     *ニックネームの入力チェックの結果を返す
     * @return bool
    */
    public function isValidNickname(): bool
    {
        return static::validateNickname($this->nickname);
    }
    /**
     *ニックネームのチェック
     *@param string|null $val
     *@return bool
    */
    public static function validateNickname(string | null $val): bool
    {
        $res = true;
        if (empty($val)) {
            Msg::push(Msg::ERROR, 'ニックネームを入力してください。');
            $res = false;
        } else {
            if (mb_strlen($val) > 10) {
                Msg::push(Msg::ERROR, 'ニックネームは１０桁以下で入力してください。');
                $res = false;
            }
        }
        return $res;
    }
}
