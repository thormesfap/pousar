<?php

use App\DAO\UsuarioDAO;
use App\Infra\Database\DatabaseManager;

include 'cabecalho.php';

$logado = false;
session_start();
if (isset($_SESSION['user'])) {
    $logado = $_SESSION['user'];
}
?>

<header>
    <span>
        <a href="/index.php"><img src="/public/assets/images/aircraft.svg"></a>
    </span>
    <nav>
        <ul>
            <li><a href="/public/Pages/aeronave.php">Aeronaves</a></li>
            <li><a href="/public/Pages/cia_aerea.php">Cias Aéreas</a></li>
            <li><a href="/public/Pages/voo.php">Vôos</a></li>
            <li><a href="/public/Pages/passageiro.php">Passageiros</a></li>
            <?php 
            if($logado){
                echo "<li><a href=\"/public/Pages/passagens.php\">Minhas Passagens</a></li>";
            }
            ?>
            <li><?php
                if (!$logado) {
                    echo '<a href="/public/Pages/login.php">Logar</a>';
                } else {
                    echo "Bem vindo {$logado->getNome()} (<a href=\"/public/Routes/logout.php\">logout</a>)";
                }
                ?>
            </li>
        </ul>
    </nav>
</header>