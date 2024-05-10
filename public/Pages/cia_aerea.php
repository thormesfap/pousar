<?php

use App\Entities\CiaAerea;

include 'templates/header.php';
require_once '../../autoload.php';

//Pegar companhias do CiaAereaDAO
$cias = [];
$cias[] = new CiaAerea("Teste 1", "Teste 1", "ABC");
$cias[] = new CiaAerea("Teste 2", "Teste 2", "CBA");
$cias[] = new CiaAerea("Teste 3", "Teste 3", "CNB");
$cias[] = new CiaAerea("Teste 4", "Teste 4", "POS");
?>

<head>
    <title>Cias Aéreas</title>
</head>
<section class="section-container">
    <h2>Companhias Cadastradas</h2>
    <div class="div-tabela">
        <span class="cabecalho-tabela">Razão Social</span>
        <span class="cabecalho-tabela">CNPJ</span>
        <span class="cabecalho-tabela">Código IATA</span>
    </div>

    </div>
    <?php
    foreach ($cias as $cia) {
        echo "<div class=\"div-tabela\">
        <span>{$cia->getRazaoSocial()}</span>
        <span>{$cia->getCnpj()}</span>
        <span>{$cia->getCodigoIata()}</span>
    </div>";
    }
    ?>
</section>
<div class="container">
    <h2>Cadastrar Companhia</h2>
    <form action="/public/Routes/cadastrarCiaAerea.php" method="POST">
        <input type="text" name="razao_social" placeholder="Razão Social" required>
        <input type="text" name="cnpj" placeholder="CNPJ">
        <input type="text" name="iata" placeholder="Código IATA">
        <input type="email" id="email" name="email" placeholder="Email">
        <input type="text" id="telefone" name="telefone" placeholder="+55">
        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>