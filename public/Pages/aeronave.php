<?php

use App\DAO\AeronaveDAO;
use App\Entities\Aeronave;

require_once '../../autoload.php';
require 'templates/header.php';

//Pegar aeronaves do AeronaveDAO
$aeronaveDAO = new AeronaveDAO();
$aeros = $aeronaveDAO->read();

if (isset($_GET['id'])) {
    if(isset($_GET['delete']) && $_GET['delete']){
        $aeronaveDAO->delete($_GET['id']);
        header("Location:/public/Pages/aeronave.php");
    }
    $aeroEdit = $aeronaveDAO->getById($_GET['id']);
    if (!$aeroEdit) {
        $aeroEdit = new Aeronave('', '', 0, 0, 0);
    }
} else {
    $aeroEdit = new Aeronave('', '', 0, 0, 0);
}
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
        <td>
        <a href=\"/public/Pages/aeronave.php?id={$aero->getId()}\"><img src=\"/public/assets/images/edit-icon.svg\"></a>
        <a href=\"/public/Pages/aeronave.php?id={$aero->getId()}&delete=true\"><img src=\"/public/assets/images/trash-icon.svg\"></a>
        </td>
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
            <input type="hidden" name="id" value="<?php echo $aeroEdit->getId() ?>">
            <label for="sigla">Sigla Aeronave</label>
            <input type="text" id="sigla" name="sigla" placeholder="Sigla" value="<?php echo $aeroEdit->getSigla() ?>" required>
        </div>
        <div class="input-group">
            <label for="marca">Nome</label>
            <input type="text" id="marca" name="marca" placeholder="Nome" value="<?php echo $aeroEdit->getMarca() ?>">
        </div>
        <div class="input-group">
            <label for="fileira">Número de Fileiras</label>
            <input type="number" id="fileira" name="fileira" placeholder="30" value="<?php echo $aeroEdit->getQuantidadeFilas() ?>">
        </div>
        <div class="input-group">
            <label for="assentos">Assentos por Fileira</label>
            <input type="number" id="assentos" name="assentos" placeholder="6" value="<?php echo $aeroEdit->getAssentosFila() ?>">
        </div>
        <div class="input-group">
            <label for="prioritarios">Assentos Prioritários</label>
            <input type="number" id="prioritarios" name="prioritarios" placeholder="6" value="<?php echo $aeroEdit->getAssentosPrioritarios() ?>">
        </div>


        <button type="submit">
            <?php
            if ($aeroEdit->getId()) {
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