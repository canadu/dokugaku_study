<?php

require_once dirname(__FILE__) . '/../db/PDOConnect.php';
class UserSql extends PDOConnection
{
    /**
     * ユーザーNoからユーザー情報を取得する
     * @param int ユーザーNo
     * @return array
     */
    public function getUserByUserNo($userNo) {
        $sql = "SELECT
            user_no
            ,user_id
            ,password
            ,user_name
            ,user_kana
            ,gender
            ,IF(birthday,DATE_FORMAT(birthday, '%Y/%m/%d'),NULL) AS birthday
            ,status
            ,memo
            ,del_flg
            ,insert_user_no
            ,insert_time
            ,update_user_no
            ,update_time
            FROM user_info
            WHERE user_no = :userNo
            AND del_fg = '0'
            ORDER BY user_no DESC";
        $dbh = $this->getDbh();
        //prepareメソッドでSQLをセット
        $prepare = $dbh->prepare($sql);
        //bindValueメソッドでパラメータをセットする
        $prepare->bindValue(':userNo',$userNo, PDO::PARAM_INT);
        //executeでクエリを実行
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * ユーザーIDからユーザー情報を取得する
     * @param String ユーザーID
     * @return User ユーザー情報 
     */
    public function getUserByUserId($userId) {
        try{
            $sql = "SELECT user_id FROM user_info
                    WHERE user_id = :userId
                    AND del_flg = '0'";
            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userId',$userId,PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){ 
            print('Error:'.$e->getMessage());
        }
    }
    /**
     * ユーザーIDとパスワードからユーザー情報を取得する
     * @param String ユーザーID
     * @param String パスワード
     * @return User ユーザー情報
     */
    public function getUserByUserIdAndPassword($userId, $password) {
        $sql = "SELECT * FROM user_info
        WHERE user_id=?
        AND password=?
        AND del_flg = '0'";
        $stmt = $this->getDbh();
        $prepare = $stmt->prepare($sql);
        $prepare->bindValue(1,$userId, PDO::PARAM_STR);
        $prepare->bindValue(2,$password,PDO::PARAM_STR);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * 全てのユーザー情報をリストで取得する
     * @return array
     */
    public function getUserList(){
        $sql = "SELECT * FROM user_info WHERE del_flg = '0' ORDER BY user_no DESC";
        $dbh = $this->getDbh();
        $prepare = $dbh->prepare($sql);
        $prepare->execute();
        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * ユーザー情報を登録する
     * @param User　ユーザー情報
     * @return array
     */
    public function insertUser($user) {
        try {
            $sql = "INSERT INTO user_info(
                user_id
                ,password
                ,username
                ,user_kana
                ,gender
                ,birthday
                ,status
                ,memo
                ,del_flg
                ,insert_user_no
                ,insert_time
                ,update_user_no
                ,update_time
                )VALUES(
                :userId
                ,:password
                ,:userName
                ,:userKana
                ,:gender
                ,:birthday
                ,:status
                ,:memo
                ,:delFlg
                ,:insertUserNo
                ,:insertTime
                ,:updateUserNo
                ,:updateTime
                )";
            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userId', $user->userId,PDO::PARAM_STR);
            $prepare->bindValue(':password', $user->password,PDO::PARAM_STR);
            $prepare->bindValue(':userName', $user->userName,PDO::PARAM_STR);
            $prepare->bindValue(':userKana', $user->userKana,PDO::PARAM_STR);
            $prepare->bindValue(':gender', $user->userKana,PDO::PARAM_INT);
            $prepare->bindValue(':birthday', $user->userKana,PDO::PARAM_STR);
            $prepare->bindValue(':status', $user->userKana,PDO::PARAM_STR);
            $prepare->bindValue(':memo', $user->userKana,PDO::PARAM_STR);
            $prepare->bindValue(':delFlg', 0, PDO::PARAM_STR);
            $prepare->bindValue(':insertUserNo', $user->insertUserNo, PDO::PARAM_INT);
            $prepare->bindValue(':insertTime', $user->insertTime, PDO::PARAM_STR);
            $prepare->bindValue(':updateUserNo', $user->updateUserNo, PDO::PARAM_INT);
            $prepare->bindValue(':updateTime', $user->updateTime, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            print('Error:'.$e->getMessage());
        }
    }
    public function updateUser($user){
        try{
            $sql = "UPDATE user_info SET
            user_id = :userId
            ,password = :password
            ,user_name = :userName
            ,user_kana = :userKana
            ,gender = :gender
            ,birthday = :birthday
            ,status = :status
            ,memo = :memo
            ,update_user_no = :updateUserNo
            ,update_time = :updateTime
            WHERE user_no = :userNo";

            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userNo',$user->userNo,PDO::PARAM_INT);
            $prepare->bindValue(':userId',$user->userId,PDO::PARAM_STR);
            $prepare->bindValue(':password',$user->password,PDO::PARAM_STR);
            $prepare->bindValue(':userName',$user->userName,PDO::PARAM_STR);
            $prepare->bindValue(':userKana',$user->userKana,PDO::PARAM_STR);
            $prepare->bindValue(':gender',$user->gender,PDO::PARAM_INT);
            $prepare->bindValue(':birthday',$user->birthday,PDO::PARAM_STR);
            $prepare->bindValue(':status',$user->status,PDO::PARAM_STR);
            $prepare->bindValue(':memo',$user->memo,PDO::PARAM_STR);
            $prepare->bindValue(':updateUserNo', $user->updateUserNo, PDO::PARAM_INT);
            $prepare->bindValue(':updateTime', $user->updateTime, PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e){ 
            print('Error:'.$e->getMessage());
        }
    }
    /**
     * ユーザー情報を削除する（論理削除）
     * @param int ユーザーNo
     * @return
     */
    public function deleteUser($userNo,$nowDate){
        try{
            $sql = "UPDATE user_info SET del_flg = '1'
            ,update_user_no = :updateUserNo
            ,update_time = :updateTime
            WHERE user_no = :userNo";
            $dbh = $this->getDbh();
            $prepare = $dbh->prepare($sql);
            $prepare->bindValue(':userNo',$userNo,PDO::PARAM_INT);
            $prepare->bindValue(':updateUserNo',0,PDO::PARAM_INT);
            $prepare->bindValue(':updateTime',$nowDate,PDO::PARAM_STR);
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            print('Error:'.$e->getMessage());
        }
    }
}