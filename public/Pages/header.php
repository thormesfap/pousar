<?php

use App\Infra\Database\DatabaseManager;

$logado = false;
session_start();
if (isset($_SESSION['user'])) {
    $logado = $_SESSION['user'];
    $conn = DatabaseManager::getConn();

    $stmt = $conn->query("SELECT * FROM usuario WHERE email=:email");
    $stmt->bindValue('email', $logado);
    $stmt->execute();
    $user = $stmt->fetchAll(PDO::FETCH_OBJ)[0];
}
?>

<header>
    <span>Pousar</span>
    <nav>
        <ul>
            <li>Home</li>
            <li>Voos</li>
            <li>Aeronaves</li>
            <li>Cias Aéreas</li>
            <li><?php
                if ($logado) {
                    echo "Perfil de {$user->nome}";
                } else {
                    echo "Logar";
                }
                ?>
            </li>
        </ul>
    </nav>
</header>