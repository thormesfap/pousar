<?php

use App\Entities\Voo;
use App\Entities\CiaAerea;
use App\Entities\Aeronave;

require 'templates/header.php';
require_once '../../autoload.php';

//Pegar voos do VooDAO
$voos = [];
$voos[] = (new Voo(320, "JDO", 'GRU', new Aeronave("100", "Fokker 100", 15, 4, 6), new CiaAerea("Teste 1", "Teste 1", "IJT")))->setHoraSaida("23:55")->setHoraChegada("03:05");
$voos[] = (new Voo(1240, "JDO", 'FOR', new Aeronave("320", "Airbus A320", 15, 4, 6), new CiaAerea("Teste 1", "Teste 1", "IJT")))->setHoraSaida("21:40")->setHoraChegada("22:45");
$voos[] = (new Voo(1805, "JDO", 'BSB', new Aeronave("787", "Boing 787", 30, 4, 6), new CiaAerea("Teste 2", "Teste 2", "TIJ")))->setHoraSaida("22:05")->setHoraChegada("00:15");

?>

<head>
    <title>Vôos</title>
</head>
<section class="section-container">
    <h2>Vôos Cadastrados</h2>
    <table class="tabela">
        <thead>
            <tr>
                <th>Número</th>
                <th>Origem</th>
                <th>Destino</th>
                <th>Hora Saída</th>
                <th>Hora Chegada</th>
                <th>Cia Aérea</th>
                <th>Aeronave</th>
            </tr>
        </thead>
        <tbody>

            <?php

            foreach ($voos as $voo) {
                echo "<tr>
            <td>{$voo->getNumero()}</td>
            <td>{$voo->getCodigoOrigem()}</td>
            <td>{$voo->getCodigoDestino()}</td>
            <td>{$voo->getHoraSaida()}</td>
            <td>{$voo->getHoraChegada()}</td>
            <td>{$voo->getCiaAerea()->getRazaoSocial()}</td>
            <td>{$voo->getAeronave()->getMarca()}</td>
            </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Voo</h2>
    <form action="/public/Routes/cadastrarVoo.php" method="POST">
        <div class="input-group">
            <label for="numero">Número do Voo</label>
            <input type="number" id="numero" name="numero" placeholder="Numero" required>
        </div>

        <div class="input-group">
            <label for="cod_origem">Código Aeroporto Origem</label>
            <input type="text" id="cod_origem" name="cod_origem" placeholder="JDO">
        </div>


        <div class="input-group">
            <label for="cod_destino">Código Aeroporto Destino</label>
            <input type="text" id="cod_destino" name="cod_destino" placeholder="GRU">
        </div>

        <div class="input-group">
            <label for="hora_saida">Hora de Saída</label>
            <input type="text" id="hora_saida" name="hora_saida" placeholder="00:00">
        </div>

        <div class="input-group">
            <label for="hora_chegada">Hora de Chegada</label>
            <input type="text" id="hora_chegada" name="hora_chegada" placeholder="03:00">
        </div>

        <div class="input-group">
            <label for="cia_aerea">Cia Aérea</label>
            <select name="cia_aerea" id="cia_aerea">
                <option value="1">Cia 1</option>
                <option value="2">Cia 2</option>
                <option value="3">Cia 3</option>
            </select>
        </div>

        <div class="input-group">
            <label for="aeronave">Aeronave</label>
            <select name="aeronave" id="aeronave">
                <option value="1">Airbus A320</option>
                <option value="2">Fokker 100</option>
                <option value="3">Boing 767</option>
            </select>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>