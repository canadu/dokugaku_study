<?php

namespace db;

use Dotenv;
use PDO;

//vendorディレクトリの階層を指定する
require __DIR__ . '/../../../vendor/autoload.php';

class DataSource
{

    private $conn;
    private $sqlResult;

    private string $dbHost;
    private string $dbUsername;
    private string $dbPassword;
    private string $dbDatabase;
    public const CLS = 'cls';

    public function __construct()
    {
        //.envの階層を指定する
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
        $this->dbDatabase = $_ENV['DB_DATABASE'];
        $dsn = "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbDatabase . ";charset=utf8mb4";

        $this->conn = new PDO($dsn, $this->dbUsername, $this->dbPassword);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    //取得下データを返す
    public function select($sql = "", $params = [], $type = '', $cls = '')
    {
        $stmt = $this->executeSql($sql, $params);
        if ($type === static::CLS) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        } else {
            return $stmt->fetchAll();
        }
    }

    //取得したデータから１行取得
    public function selectOne($sql = "", $params = [], $type = '', $cls = '')
    {
        $result = $this->select($sql, $params, $type, $cls);
        return count($result) > 0 ? $result[0] : false;
    }

    //sql実行
    public function execute($sql = "", $params = [])
    {
        $this->executeSql($sql, $params);
        return  $this->sqlResult;
    }

    private function executeSql($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        $this->sqlResult = $stmt->execute($params);
        return $stmt;
    }

    //トランザクション
    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }
}
