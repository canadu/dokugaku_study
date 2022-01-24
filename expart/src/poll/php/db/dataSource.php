<?php

namespace db;

use Dotenv;
use PDO;
use PDOStatement;
use phpDocumentor\Reflection\Types\Mixed_;

//vendorディレクトリの階層を指定する
require __DIR__ . '/../../../vendor/autoload.php';

class PDOSingleTone
{
    private static $SingleTone;

    private function __construct($dsn, $username, $password)
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

    public static function getInstance($dsn, $username, $password)
    {
        if (!isset(self::$SingleTone)) {
            $instance = new PDOSingleTone($dsn, $username, $password);
            self::$SingleTone = $instance->conn;
        }
        return self::$SingleTone;
    }
}


class DataSource
{
    private PDO $conn;
    private bool $sqlResult;
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

        //$this->conn = new PDO($dsn, $this->dbUsername, $this->dbPassword);
        $this->conn = PdoSingleTone::getInstance($dsn, $this->dbUsername, $this->dbPassword);
    }

    //取得下データを返す
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     *  @param string $type
     *  @param string $cls
     */
    public function select(string $sql = "", array $params = [], string $type = '', string $cls = ''): mixed
    {
        $stmt = $this->executeSql($sql, $params);
        if ($type === static::CLS) {
            return $stmt->fetchAll(PDO::FETCH_CLASS, $cls);
        } else {
            return $stmt->fetchAll();
        }
    }

    //取得したデータから１行取得
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     *  @param string $type
     *  @param string $cls

     */
    public function selectOne(string $sql = "", array $params = [], string $type = '', string $cls = ''): mixed
    {
        $result = $this->select($sql, $params, $type, $cls);
        return count($result) > 0 ? $result[0] : false;
    }

    //sql実行
    /**
     *  @param string $sql
     *  @param array<mixed> $params
     */
    public function execute(string $sql = "", array $params = []): bool
    {
        $this->executeSql($sql, $params);
        return  $this->sqlResult;
    }

    /**
     *  @param string $sql
     *  @param array<mixed> $params
     */
    private function executeSql(string $sql, array $params): PDOStatement
    {
        $stmt = $this->conn->prepare($sql);
        $this->sqlResult = $stmt->execute($params);
        return $stmt;
    }

    //トランザクション
    public function begin(): void
    {
        $this->conn->beginTransaction();
    }

    public function commit(): void
    {
        $this->conn->commit();
    }

    public function rollback(): void
    {
        $this->conn->rollback();
    }
}
