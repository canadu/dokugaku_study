<?php

/** 
*ログイン情報エンティティ
*/
class Login
{
    // ユーザ NO
    public $userNo;
    // セッション ID
    public $sessionId;
    // ログイン時間
    public $loginTime;
    // ログアウト時間
    public $logoutTime;
    // 最終アクセス日時
    public $lastAccessTime;
    // ステータス
    public $status;
    // 登録者
    public $insertUserNo;
    // 追加日
    public $insertTime;
    // 更新者
    public $updateUserNo;
    // 更新日
    public $updateTime;

    /** 
    * @param String ユーザーNo
    * @param String セションID
    * @param String ログイン時間
    * @param String ログアウト時間
    * @param String 最終アクセス日時
    * @param String ステータス
    * @param String 登録者
    * @param String 追加日
    * @param String 更新者
    * @param String 更新日
    */  
    function __construct($userNo,$sessionId,$loginTime,$logoutTime,$lastAccessTime,
                        $status,$insertUserNo,$insertTime,$updateUserNo,$updateTime)
    {
        $this->userNo = $this->getVal($userNo);
        $this->sessionId = $this->getVal($sessionId);
        $this->loginTime = $this->getVal($loginTime);
        $this->logoutTime = $this->getVal($logoutTime);
        $this->lastAccessTime = $this->getVal($lastAccessTime);
        $this->status = $this->getVal($status);
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