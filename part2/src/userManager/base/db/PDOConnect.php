<?php

require __DIR__ . '/../../vendor/autoload.php';

class PDOConnection {

    private string $dbHost;
    private string $dbUsername;
    private string $dbPassword;
    private string $dbDatabase;
    private $dbh = null;

    /** 
     * データベース接続
    */
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
        $dotenv->load();
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
        $this->dbDatabase = $_ENV['DB_DATABASE'];
        $dsn = "mysql:host=".$this->dbHost.";dbname=".$this->dbDatabase.";charset=utf8mb4";
        try {
            $this->dbh = new PDO($dsn, $this->dbUsername, $this->dbPassword,array(PDO::ATTR_EMULATE_PREPARES=>false));
            $this->dbh;
        } catch(Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
    * @return PDO
    */
    public function getDbh() {
        return $this->dbh;
    }
    
    /**
    * 現在日付を取得する
    * @return string 現在日付
    */
    public function getNow() {
        $sql = "SELECT NOW() AS NOW_DATE";
        $dbh = $this->getDbh();
        $prepare = $dbh->prepare($sql);
        $prepare->execute();
        if ($row = $prepare->fetch()) {
            return $row['NOW_DATE'];
        }
    }

    /**
    * 現在日付を取得する(ミリ秒まで)
    * @return string 現在日付(ミリ秒まで)
    */
    public function getNowMillisecond() {
        $sql = "SELECT DATE_FORMAT(NOW(),'%Y%m%d%H%i%S%f') AS NOW_DATE";
        $dbh = $this->getDbh();
        $prepare = $dbh->prepare($sql);
        if($row = $prepare->fetch()){
            return $row['NOW_DATE'];
        }
    }

}