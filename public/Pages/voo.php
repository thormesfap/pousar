<?php

use App\Entities\Voo;
use App\Entities\CiaAerea;
use App\Entities\Aeronave;
use App\DAO\VooDAO;
use App\DAO\CiaAereaDAO;
use App\DAO\AeronaveDAO;

require_once '../../autoload.php';
require 'templates/header.php';

//Pegar voos do VooDAO

$vooDAO = new VooDAO();
$voos = $vooDAO->read();
$aeronaveDAO = new AeronaveDAO();
$ciaAereaDAO = new CiaAereaDAO();
if (isset($_GET['id'])) {
    if (isset($_GET['delete']) && $_GET['delete']) {
        $request = $vooDAO->delete((int) $_GET['id']);
        if ($request) {
            header("Location:/public/Pages/voo.php");
        }
    }
    $vooEdit = $vooDAO->getById($_GET['id']);
    if (!$vooEdit) {
        $vooEdit = new Voo(0, '', '', new Aeronave('', '', 0, 0, 0), new CiaAerea('', '', ''));
    }
} else {
    $vooEdit = new Voo(0, '', '', new Aeronave('', '', 0, 0, 0), new CiaAerea('', '', ''));
}
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
                    <td>
        <a href=\"/public/Pages/voo.php?id={$voo->getId()}\"><img src=\"/public/assets/images/edit-icon.svg\"></a>
        <a href=\"/public/Pages/voo.php?id={$voo->getId()}&delete=true\"><img src=\"/public/assets/images/trash-icon.svg\"></a>
        <a href=\"/public/Pages/passagem.php?id_voo={$voo->getId()}\"><img src=\"/public/assets/images/money-icon.svg\"></a>
        </td>
            </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Voo</h2>
    <form action="/public/Routes/cadastrarVoo.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $vooEdit->getId() ?>">
        <div class="input-group">
            <label for="numero">Número do Voo</label>
            <input type="number" id="numero" name="numero" placeholder="Numero" value="<?php echo $vooEdit->getNumero() ?>" required>
        </div>

        <div class="input-group">
            <label for="cod_origem">Código Aeroporto Origem</label>
            <input type="text" id="cod_origem" name="cod_origem" placeholder="JDO" value="<?php echo $vooEdit->getCodigoOrigem() ?>">
        </div>


        <div class="input-group">
            <label for="cod_destino">Código Aeroporto Destino</label>
            <input type="text" id="cod_destino" name="cod_destino" placeholder="GRU" value="<?php echo $vooEdit->getCodigoDestino() ?>">
        </div>

        <div class="input-group">
            <label for="hora_saida">Hora de Saída</label>
            <input type="text" id="hora_saida" name="hora_saida" placeholder="00:00" value="<?php echo $vooEdit->getHoraSaida() ?>">
        </div>

        <div class="input-group">
            <label for="hora_chegada">Hora de Chegada</label>
            <input type="text" id="hora_chegada" name="hora_chegada" placeholder="03:00" value="<?php echo $vooEdit->getHoraChegada() ?>">
        </div>

        <div class="input-group">
            <label for="cia_aerea">Cia Aérea</label>
            <select name="cia_aerea" id="cia_aerea">
                <?php
                $cias = $ciaAereaDAO->read();
                foreach ($cias as $cia) {
                    $selecionada = '';
                    if ($cia->getId() == $vooEdit->getCiaAerea()->getId() ?? '') {
                        $selecionada = 'selected';
                    }
                    echo "<option $selecionada value=\"{$cia->getId()}\">{$cia->getRazaoSocial()}</option>";
                }
                ?>
            </select>
        </div>

        <div class="input-group">
            <label for="aeronave">Aeronave</label>
            <select name="aeronave" id="aeronave">
                <?php
                $aeronaves = $aeronaveDAO->read();
                foreach ($aeronaves as $aero) {
                    $selecionada = '';
                    if ($aero->getId() == $vooEdit->getAeronave()->getId() ?? '') {
                        $selecionada = 'selected';
                    }
                    echo "<option $selecionada value=\"{$aero->getId()}\">{$aero->getSigla()} - {$aero->getMarca()}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">
            <?php
            if ($vooEdit->getId()) {
                echo "Atualizar";
            } else {
                echo "Cadastrar";
            }
            ?>
        </button>
    </form>
</div>
<?php
require 'templates/final.php';
?>