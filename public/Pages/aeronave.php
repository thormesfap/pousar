<?php

use App\Entities\Aeronave;

require 'templates/header.php';
require_once '../../autoload.php';

//Pegar companhias do CiaAereaDAO
$aeros = [];
$aeros[] = new Aeronave("320", "Airbus A320", 30, 6, 6);
$aeros[] = new Aeronave("100", "Fokker 100", 15, 4, 6);
$aeros[] = new Aeronave("767", "Boing 767", 25, 6, 6);
?>

<head>
    <title>Aeronaves</title>
</head>
<section class="section-container">
    <h2>Aeronaves Cadastradas</h2>
    <div class="div-tabela">
        <span class="cabecalho-tabela">Sigla</span>
        <span class="cabecalho-tabela">Nome</span>
        <span class="cabecalho-tabela">Assentos Disponíveis</span>
    </div>

    </div>
    <?php
    foreach ($aeros as $aero) {
        echo "<div class=\"div-tabela\">
        <span>{$aero->getSigla()}</span>
        <span>{$aero->getMarca()}</span>
        <span>" . $aero->getAssentosFila() * $aero->getQuantidadeFilas() . "</span>
    </div>";
    }
    ?>
</section>
<div class="container">
    <h2>Cadastrar Aeronave</h2>
    <form action="/public/Routes/cadastrarAeronave.php" method="POST">
        <input type="text" name="sigla" placeholder="Sigla" required>
        <input type="text" name="marca" placeholder="Nome">
        <input type="number" name="fileira" placeholder="30">
        <input type="number" name="assentos" placeholder="6">
        <input type="number" name="prioritarios" placeholder="6">
        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>