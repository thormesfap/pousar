<?php

use App\DAO\PassageiroDAO;
use App\DAO\VooDAO;
use App\Entities\Passageiro;

require_once '../../autoload.php';
include 'templates/header.php';

if (!$logado) {
    header("Location:/public/Pages/login.php");
}
/**
 * @var Usuario $logado
 */

if (!isset($_GET['id_voo'])) {
    header("Location:/public/Pages/voo.php");
}
$idVoo = $_GET['id_voo'];
$vooDAO = new VooDAO();
$voo = $vooDAO->getById($idVoo);

$passageiroDAO = new PassageiroDAO();
?>

<head>
    <title>Comprar Passagem</title>
</head>
<section class="section-container">
    <h2>Dados Voo</h2>
    <table class="tabela">
        <thead>
            <tr>
                <th>Origem</th>
                <th>Destino</th>
                <th>Hora Saída</th>
                <th>Hora Chegada</th>
                <th>Cia Aérea</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>

            <?php
            echo "<tr>
            <td>{$voo->getCodigoOrigem()}</td>
            <td>{$voo->getCodigoDestino()}</td>
            <td>{$voo->getHoraSaida()}</td>
            <td>{$voo->getHoraChegada()}</td>
            <td>{$voo->getCiaAerea()->getRazaoSocial()}</td>
            <td>R$ " . number_format($voo->getValor(), 2,",",".") . "</td>
            </tr>";
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Comprar Para Passageiro:</h2>
    <form action="/public/Routes/comprarPassagem.php" method="POST">
        <input type="hidden" name="id_voo" value="<?php echo $voo->getId() ?>">
        <input type="hidden" name="id_comprador" value="<?php echo $logado->getId() ?>">
        <div class="input-group">
            <label for="data">Data</label>
            <input name="data" id="data" type="date" required>
        </div>
        <div class="input-group">
            <label for="passageiro">Passageiro</label>
            <select name="passageiro" id="passageiro" required>
                <option></option>
                <?php
                $passageiros = $passageiroDAO->read();
                foreach($passageiros as $passageiro){
                    if($passageiro->getUsuario()->getId() == $logado->getId()){
                        echo "<option value=\"{$passageiro->getId()}\">{$passageiro->getNome()} ({$passageiro->getEmail()})</option>";
                    }
                }
                ?>
            </select>
        </div>
        <button type="submit">Comprar</button>
    </form>
</div>
<?php
require 'templates/final.php';
?>