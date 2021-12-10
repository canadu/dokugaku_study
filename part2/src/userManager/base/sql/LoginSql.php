<?php
/**
 * ログインSQL
 */
require_once dirname(__FILE__) . '/../db/PDOConnect.php';
class LoginSql extends PDOConnection
{
    /**
     * ログイン情報をセッションIDから取得します
     * @param String セッションID
     * @return array ログイン情報
     */
    public function getLoginInfoBySessionId($sessionId) {
        try{
            $sql = "SELECT * FROM login_info WHERE session_id=:sessionId
            AND last_access_time >= CURRENT_TIMESTAMP + INTERVAL - (10)MINUTE 
            AND logout_time = '0000-00-00 00:00:00'";
            
            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':sessionId',$sessionId, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            print('Error:'.$e->getMessage());
        }
    }
    /**
     * ログイン情報を登録
     * @param Login ログイン
     * @param number 
     */
    public function insertLoginInfo($loginInfo) {
        try {
            $sql = "INSERT INTO login_info(
                user_no
                ,session_id
                ,login_time
                ,logout_time
                ,last_access_time
                ,status
                ,del_fg
                ,insert_user_no
                ,insert_time
                ,update_user_no
                ,update_time
                )VALUES(
                :userNo
                ,:session_id
                ,:login_time
                ,:logout_time
                ,:last_access_time
                ,:status
                ,:del_fg
                ,:insert_user_no
                ,:insert_time
                ,:update_user_no
                ,:update_time
                )";
            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userNo', $loginInfo->userNo,PDO::PARAM_INT);
            $prepare->bindValue(':sessionId', $loginInfo->sessionId, PDO::PARAM_STR);
            $prepare->bindValue(':loginTime', $loginInfo->loginTime, PDO::PARAM_STR);
            $prepare->bindValue(':logoutTime', $loginInfo->logoutTime, PDO::PARAM_STR);
            $prepare->bindValue(':lastAccessTime', $loginInfo->lastAccessTime, PDO::PARAM_STR);
            $prepare->bindValue(':status', $loginInfo->status, PDO::PARAM_STR);
            $prepare->bindValue(':delFlg', '0', PDO::PARAM_STR);
            $prepare->bindValue(':insertUserNo', $loginInfo->insertUserNo, PDO::PARAM_INT);
            $prepare->bindValue(':insertTime', $loginInfo->insertTime, PDO::PARAM_STR);
            $prepare->bindValue(':updateUserNo', $loginInfo->updateUserNo, PDO::PARAM_INT);
            $prepare->bindValue(':updateTime', $loginInfo->updateTime, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->rowCount();
        } catch(PDOException $e) {
            print('Error:'.$e->getMessage());
        }
    }

    /**
     * ログアウト時間の更新
     * @param String セッションID
     * @param String ログアウト時間
     * @return array
     */
    function updaterLogOutInfo($sessionId, $logoutTime) {
        try{
            $sql = "UPDATE login_info SET
            logout_time = :logoutTime
            ,update_user_no = :updateUserNo
            ,update_time = :updateTime
            WHERE session_id = :sessionId";

            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':logoutTime',$logoutTime, PDO::PARAM_STR);
            $prepare->bindValue(':updateUserNo',0, PDO::PARAM_INT);
            $prepare->bindValue(':updateTime',$logoutTime, PDO::PARAM_STR);
            $prepare->bindValue(':sessionId',$sessionId, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){ 
            print('Error:'.$e->getMessage());
        }
    }

    /**
     * 最終更新日
     * @param String セッションID
     * @param String 現在日付
     * @return array
     */
    public function updaterLastAccessTime($sessionId, $now){
        try {
            $sql = "UPDATE login_info SET
            last_access_time = :lastAccessTime
            ,login_time = :login_time
            ,update_user_no = :updateUserNo
            ,update_time = :updateTime
            WHERE session_id = :sessionId";

            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':lastAccessTime',$now, PDO::PARAM_STR);
            $prepare->bindValue(':updateUserNo',0, PDO::PARAM_INT);
            $prepare->bindValue(':updateTime',$now, PDO::PARAM_STR);
            $prepare->bindValue(':sessionId',$sessionId, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            print('Error:'.$e->getMessage());
        }
    }
}