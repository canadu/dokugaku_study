<?php

require __DIR__ . '/../vendor/autoload.php';

function db_connect(){
	
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];
    $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8;';
	try{
		$dbh = new PDO($dsn, $dbUsername, $dbPassword);
		return $dbh;
	}catch (PDOException $e){
        print('Error:'.$e->getMessage());
        die();
	}
}