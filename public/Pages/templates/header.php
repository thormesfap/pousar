<?php

use App\Infra\Database\DatabaseManager;

include 'cabecalho.php';

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
    <span>
        <img src="/public/assets/images/aircraft.svg">
    </span>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li>Voos</li>
            <li><a href="/public/Pages/aeronave.php">Aeronaves</a></li>
            <li><a href="/public/Pages/cia_aerea.php">Cias Aéreas</a></li>
            <li><?php
                if ($logado) {
                    echo "Bem vindo {$user->nome} (<a href=\"/public/Routes/logout.php\">logout</a>)";
                } else {
                    echo '<a href="/public/Pages/login.php">Logar</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
</header>