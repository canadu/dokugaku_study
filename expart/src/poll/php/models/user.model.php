<?php

namespace model;

use phpDocumentor\Reflection\Types\AbstractList;

class UserModel extends AbstractModel
{
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    //なにか特定のメソッドを通じて値を取得するようなものにアンダースコアをつける！
    protected static $SESSION_NAME = '_user';
}
