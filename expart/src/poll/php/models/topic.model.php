<?php

namespace model;

use lib\Msg;

class TopicModel extends AbstractModel
{
    public int $id;
    public string $title;
    public int $published;
    public int $views;
    public int $likes;
    public int $dislikes;
    public string $user_id;
    public int $del_flg;
    public string $updated_by;
    public string $nickname; //topicにはnicknameはないけど、関数の引数に複数の型(TopicModel|UserModel $topic)が宣言されている箇所がある。
    public string $updated_at;

    //なにか特定のメソッドを通じて値を取得するようなものにアンダースコアをつける！
    protected static mixed $SESSION_NAME = '_topic';

    /**
     * トピックIDチェックの結果を返す
     * @return bool
    */
    public function isValidId(): bool
    {
        return static::validateId($this->id);
    }
    /**
     * トピックIDのチェック
     *@param int|null $val
     *@return bool
    */
    public static function validateId(int | null $val): bool
    {
        $res = true;

        if (empty($val) || !is_numeric($val)) {
            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            $res = false;
        }
        return $res;
    }
    /**
     * タイトルチェックの結果を返す
     * @return bool
    */
    public function isValidTitle(): bool
    {
        return static::validateTitle($this->title);
    }
    /**
     *タイトル項目のチェック
     *@param string|null $val
     *@return bool
    */
    public static function validateTitle(string | null $val): bool
    {
        $res = true;

        if (empty($val)) {
            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            $res = false;
        } else {
            if (mb_strlen($val) > 30) {
                Msg::push(Msg::ERROR, 'タイトルは30文字以内で入力してください。');
                $res = false;
            }
        }
        return $res;
    }

    /**
     * 公開チェックの結果を返す
     * @return bool
    */
    public function isValidPublished(): bool
    {
        return static::validatePublished($this->published);
    }
    /**
     *タイトル項目のチェック
     *@param int|null $val
     *@return bool
    */
    public static function validatePublished($val): bool
    {
        $res = true;

        if (!isset($val)) {
            Msg::push(Msg::ERROR, '公開するか選択してください。');
            $res = false;
        } else {
            // 0、または1以外の時
            if (!($val == 0 || $val == 1)) {
                Msg::push(Msg::ERROR, '公開ステータスが不正です。');
                $res = false;
            }
        }
        return $res;
    }
}
