<?php

use App\DAO\PassageiroDAO;
use App\Entities\Passageiro;

require_once '../../autoload.php';
include 'templates/header.php';

if(!$logado){
    header("Location:/public/Pages/login.php");
}
/**
 * @var Usuario $logado
 */

$passageiroDAO = new PassageiroDAO();
$passageiros = $passageiroDAO->read();
if (isset($_GET['id'])) {
    if (isset($_GET['delete']) && $_GET['delete']) {
        $passageiroDAO->delete($_GET['id']);
        header("Location:/public/Pages/passageiro.php");
    }
    $passageiroEdit = $passageiroDAO->getById($_GET['id']);
    if (!$passageiroEdit) {
        $passageiroEdit = new Passageiro('', '', '');
    }
} else {
    $passageiroEdit = new Passageiro('', '', '');
}
?>

<head>
    <title>Passageiros</title>
</head>
<section class="section-container">
    <h2>Passageiros Cadastrados</h2>
    <table class="tabela">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone da Pessoa de Contato</th>
                <th>Cadastrado Por</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($passageiros as $passageiro) {
                if($passageiro->getUsuario()->getId() != $logado->getId()){
                    continue;
                }
                echo "<tr>
                        <td>{$passageiro->getNome()}</td>
                        <td>{$passageiro->getEmail()}</td>
                        <td>{$passageiro->getTelefoneContato()}</td>
                        <td>{$passageiro->getUsuario()->getNome()}</td>
                        <td>
                        <a href=\"/public/Pages/passageiro.php?id={$passageiro->getId()}\"><img src=\"/public/assets/images/edit-icon.svg\"></a>
                        <a href=\"/public/Pages/passageiro.php?id={$passageiro->getId()}&delete=true\"><img src=\"/public/assets/images/trash-icon.svg\"></a>
                        </td>
                        </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<div class="container">
    <h2>Cadastrar Passageiro</h2>
    <form action="/public/Routes/cadastrarPassageiro.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $passageiroEdit->getId() ?? '' ?>">
        <input type="hidden" name="id_usuario" value="<?php echo $logado->getId() ?>">
        <div class="input-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?php echo $passageiroEdit->getNome() ?>" placeholder="Nome" required>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $passageiroEdit->getEmail() ?? '' ?>">
        </div>
        <div class="input-group">
            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $passageiroEdit->getCpf() ?>">
        </div>
        <div class="input-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" placeholder="+55" value="<?php echo $passageiroEdit->getTelefone() ?? '' ?>">
        </div>
        <div class="input-group">
            <label for="telefone_contato">Telefone da Pessoa de Contato</label>
            <input type="text" id="telefone_contato" name="telefone_contato" placeholder="+55" value="<?php echo $passageiroEdit->getTelefoneContato() ?? '' ?>">
        </div>
        <button type="submit">
            <?php
            if ($passageiroEdit->getId()) {
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