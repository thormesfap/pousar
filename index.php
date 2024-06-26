<?php

use App\Infra\Database\DatabaseManager;
use App\Infra\Database\DatabaseCreator;
require_once 'autoload.php';
    $db = DatabaseManager::getConn();
    try {
        $db->query('SELECT * FROM usuario');
    } catch (\PDOException $e) {
        $creator = new DatabaseCreator(DatabaseCreator::SQLITE);
        $creator->up();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pousar</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>

<body>
    <?php
    include "public/Pages/templates/header.php";
    ?>
    <section class="section-container">
        <h2>Pousar</h2>
        <p>Viaje pelo Brasil</p>
        <img src="/public/assets/images/world.svg">
    </section>
</body>

</html>