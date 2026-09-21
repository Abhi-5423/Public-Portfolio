<?php namespace App\Database;
use App\Config\Env; use PDO;
final class MySQLConnection implements DatabaseInterface { private PDO $pdo; public function __construct(){ $dsn='mysql:host='.Env::get('MYSQL_HOST','127.0.0.1').';port='.Env::get('MYSQL_PORT','3306').';dbname='.Env::get('MYSQL_DATABASE').';charset=utf8mb4'; $this->pdo=new PDO($dsn,Env::get('MYSQL_USERNAME'),Env::get('MYSQL_PASSWORD'),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); } public function pdo(): PDO{return $this->pdo;} public function driver(): string{return 'mysql';} }
