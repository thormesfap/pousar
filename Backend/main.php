<?php
use App\Infra\Database\DatabaseCreator;
use App\Infra\Database\DatabaseManager;

require 'autoloader.php';


$db = DatabaseManager::getInstance();
try{
    $db->query('SELECT * FROM usuario');
} catch(\PDOException $e){
    $creator = new DatabaseCreator(DatabaseCreator::SQLITE);
    $creator->up();
}

