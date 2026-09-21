<?php namespace App\Database;
use App\Config\Env; use MongoDB\Client; use MongoDB\Database;
final class MongoConnection implements DatabaseInterface { private Database $db; public function __construct(){ $this->db=(new Client(Env::get('MONGODB_URI','mongodb://127.0.0.1:27017')))->selectDatabase(Env::get('MONGODB_DATABASE','student_portfolio')); } public function db(): Database{return $this->db;} public function driver(): string{return 'mongodb';} }
