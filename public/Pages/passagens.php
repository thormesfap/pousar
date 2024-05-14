<?php

use App\DAO\PassageiroDAO;
use App\DAO\PassagemDAO;
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


$passagensDAO = new PassagemDAO();
$passagens = $passagensDAO->getByUsuarioId($logado->getId());
?>

<head>
    <title>Passagens Compradas</title>
</head>
<section class="section-container">
    <h2>Minhas Passagens</h2>
    <table class="tabela">
        <thead>
            <tr>
                <th>Origem</th>
                <th>Destino</th>
                <th>Data Viagem</th>
                <th>Passageiro</th>
                <th>Cia Aérea</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach($passagens as $passagem){
                echo "<tr>
                <td>{$passagem->getOrigem()}</td>
                <td>{$passagem->getDestino()}</td>
                <td>{$passagem->getDataSaida()->format('d/m/Y')}</td>
                <td>{$passagem->getPassageiro()->getNome()}</td>
                <td>{$passagem->getCiaAerea()->getRazaoSocial()}</td>
                <td>R$ ". number_format($passagem->getValor(), 2, ",", ".") ."</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</section>
<?php
require 'templates/final.php';
?>