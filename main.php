<?php
use App\Infra\Database\DatabaseCreator;
use App\Infra\Database\DatabaseManager;
use App\Infra\Database\dbType;

require 'autoloader.php';


$db = DatabaseManager::getInstance();
try{
    $db->query('SELECT * FROM usuario');
} catch(\PDOException $e){
    $creator = new DatabaseCreator(dbType::SQLITE);
    $creator->up();
}


