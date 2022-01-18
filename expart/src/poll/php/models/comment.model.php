<?php

namespace model;

use lib\Msg;

class CommentModel extends AbstractModel
{
    public int $id;
    public int $topic_id;
    public string $user_id;
    public int $del_flg;
    public string $body;
    public string $agree;
    public string $nickname;
    /**
     * 賛否項目チェックの結果を返す
     * @return bool
    */
    public function isValidAgree(): bool
    {
        return static::validateAgree($this->agree);
    }
    /**
     * 賛否項目のチェック
     *@param string|null $val
     *@return bool
    */
    public static function validateAgree(string | null $val): bool
    {
        $res = true;
        if (!isset($val)) {
            Msg::push(Msg::ERROR, '賛成か反対か選択してください。');

            // publishedが0、または1以外の時
            if (!($val == 0 || $val == 1)) {
                Msg::push(Msg::ERROR, '賛成か反対、どちらかの値を選択してください。');
            }
            $res = false;
        }
        return $res;
    }
    /**
     * 本文チェックの結果を返す
     * @return bool
     */
    public function isValidBody(): bool
    {
        return static::validateBody($this->body);
    }
    /**
     * 本文項目のチェック
     *@param string|null $val
     *@return bool
     */
    public static function validateBody(string | null $val): bool
    {
        $res = true;
        if (mb_strlen($val) > 100) {
            Msg::push(Msg::ERROR, 'コメントは100文字以内で入力してください。');
            $res = false;
        }
        return $res;
    }
    /**
     * トピックIDのチェック結果を返す
     *@return bool
     */
    public function isValidTopicId(): bool
    {
        return TopicModel::validateId($this->topic_id);
    }
}
