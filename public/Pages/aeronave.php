<?php

use App\Entities\Aeronave;

require 'templates/header.php';
require_once '../../autoload.php';

//Pegar aeronaves do AeronaveDAO
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
    <table class="tabela">
        <thead>
            <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th>Assentos</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($aeros as $aero) {
                echo "<tr>
        <td>{$aero->getSigla()}</td>
        <td>{$aero->getMarca()}</td>
        <td>" . $aero->getAssentosFila() * $aero->getQuantidadeFilas() . "</td>
    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Aeronave</h2>
    <form action="/public/Routes/cadastrarAeronave.php" method="POST">
        <div class="input-group">

        </div>
        <div class="input-group">
            <label for="sigla">Sigla Aeronave</label>
            <input type="text" id="sigla" name="sigla" placeholder="Sigla" required>
        </div>
        <div class="input-group">
            <label for="marca">Nome</label>
            <input type="text" id="marca" name="marca" placeholder="Nome">
        </div>
        <div class="input-group">
            <label for="fileira">Número de Fileiras</label>
            <input type="number" id="fileira" name="fileira" placeholder="30">
        </div>
        <div class="input-group">
            <label for="assentos">Assentos por Fileira</label>
            <input type="number" id="assentos" name="assentos" placeholder="6">
        </div>
        <div class="input-group">
            <label for="prioritarios">Assentos Prioritários</label>
            <input type="number" id="prioritarios" name="prioritarios" placeholder="6">
        </div>


        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>