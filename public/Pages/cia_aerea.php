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
    <table class="tabela">
        <thead>
            <tr>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>Código IATA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cias as $cia) {
                echo "<tr>
                        <td>{$cia->getRazaoSocial()}</td>
                        <td>{$cia->getCnpj()}</td>
                        <td>{$cia->getCodigoIata()}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Companhia</h2>
    <form action="/public/Routes/cadastrarCiaAerea.php" method="POST">
        <div class="input-group">
            <label for="razao_social">Razão Social</label>
            <input type="text" id="razao_social" name="razao_social" placeholder="Razão Social" required>
        </div>
        <div class="input-group">
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ">
        </div>
        <div class="input-group">
            <label for="iata">Código IATA</label>
            <input type="text" id="iata" name="iata" placeholder="Código IATA">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email">
        </div>
        <div class="input-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="+55">
        </div>
        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>