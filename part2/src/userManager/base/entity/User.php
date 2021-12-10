<?php

/**
 * ユーザー情報エンティティ
 */
class User{

    // ユーザ NO    
    public $userNo;
    // ユーザ ID
    public $userId;
    // パスワード
    public $password;
    // ユーザ名
    public $userName;
    // ユーザかな
    public $userKana;
    // 性別
    public $gender;
    // 生年月日
    public $birthday;
    // ステータス
    public $status;
    // 備考
    public $memo;
    // 削除 Flg
    public $delFlg;
    // 登録者
    public $insertUserNo;
    // 追加日
    public $insertTime;
    // 更新者
    public $updateUserNo;
    // 更新日
    public $updateTime;

    /** 
     * コントラスタ
     * @param String ユーザーNo
     * @param String ユーザーID
     * @param String パスワード
     * @param String ユーザー名
     * @param String ユーザーかな
     * @param String 性別
     * @param String 生年月日
     * @param String ステータス
     * @param String 備考
     * @param String 削除フラグ
     * @param String 登録者
     * @param String 追加日
     * @param String 更新者
     * @param String 更新日
    */

    public function __construct($userNo,$userId,$password,$userName,$userKana,
    $gender,$birthday,$memo,$delFlg,$insertUserNo,$insertTime,$updateUserNo,$updateTime)
    {
    $this->userNo = $this->getVal($userNo);
    $this->userId = $this->getVal($userId);
    $this->password = $this->getVal($password);
    $this->userName = $this->getVal($userName);
    $this->userKana = $this->getVal($userKana);
    $this->gender = $this->getVal($gender);
    $this->birthday = $this->getVal($birthday);
    $this->memo = $this->getVal($memo);
    $this->delFlg = $this->getVal($delFlg);
    $this->insertUserNo = $this->getVal($insertUserNo);
    $this->insertTime = $this->getVal($insertTime);
    $this->updateUserNo = $this->getVal($updateUserNo);
    $this->updateTime = $this->getVal($updateTime);
    }
    
    /** 
     * 整形した文字列の取得
     * @param String 変換する項目
     * @param String 不正な文字列を直す
    */
    private function getVal($item) {
        if ($item == "") {
            return "";
        }
        return $item;
    }
}

