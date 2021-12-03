<?php

require __DIR__ . '/../../vendor/autoload.php';

class myDb {

    private string $dbHost;
    private string $dbUsername;
    private string $dbPassword;
    private string $dbDatabase;
    private $dbh;

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
            $this->dbh = new PDO($dsn, $this->dbUsername, $this->dbPassword);
        } catch(Exception $e) {
            exit($e->getMessage());
        }
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 
    }
    
    public function query($sql, $param = null){
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($param);
        return $stmt;
    }
}