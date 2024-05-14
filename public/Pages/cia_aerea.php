<?php

use App\DAO\CiaAereaDAO;
use App\Entities\CiaAerea;

require_once '../../autoload.php';
include 'templates/header.php';

//Pegar companhias do CiaAereaDAO
$ciaDAO = new CiaAereaDAO();

$cias = $ciaDAO->read();
if (isset($_GET['id'])) {
    if(isset($_GET['delete']) && $_GET['delete']){
        $ciaDAO->delete($_GET['id']);
        header("Location:/public/Pages/cia_aerea.php");
    }
    $ciaEdit = $ciaDAO->getById($_GET['id']);
    if (!$ciaEdit) {
        $ciaEdit = new CiaAerea('', '', '');
    }
} else {
    $ciaEdit = new CiaAerea('', '', '');
}
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
                        <td>
                        <a href=\"/public/Pages/cia_aerea.php?id={$cia->getId()}\"><img src=\"/public/assets/images/edit-icon.svg\"></a>
                        <a href=\"/public/Pages/cia_aerea.php?id={$cia->getId()}&delete=true\"><img src=\"/public/assets/images/trash-icon.svg\"></a>
                        </td>
                        </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Companhia</h2>
    <form action="/public/Routes/cadastrarCiaAerea.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $ciaEdit->getId() ?? '' ?>">
        <div class="input-group">
            <label for="razao_social">Razão Social</label>
            <input type="text" id="razao_social" name="razao_social" value="<?php echo $ciaEdit->getRazaoSocial() ?>" placeholder="Razão Social" required>
        </div>
        <div class="input-group">
            <label for="cnpj">CNPJ</label>
            <input type="text" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $ciaEdit->getCnpj() ?>">
        </div>
        <div class="input-group">
            <label for="iata">Código IATA</label>
            <input type="text" id="iata" name="iata" placeholder="Código IATA" value="<?php echo $ciaEdit->getCodigoIata() ?>">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $ciaEdit->getEmail() ?? '' ?>">
        </div>
        <div class="input-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="+55" value="<?php echo $ciaEdit->getTelefone() ?? '' ?>">
        </div>
        <button type="submit">
            <?php
            if ($ciaEdit->getId()) {
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