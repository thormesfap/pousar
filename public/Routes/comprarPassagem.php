<?php

use App\Entities\Voo;
use App\Entities\Trecho;
use App\Entities\Passagem;
use App\DAO\VooDAO;
use App\DAO\UsuarioDAO;
use App\DAO\PassagemDAO;
use App\DAO\PassageiroDAO;
use App\DAO\CiaAereaDAO;
use App\DAO\AeronaveDAO;

require '../../autoload.php';

$data = $_POST;

$aeroDAO = new AeronaveDAO();
$ciaDAO = new CiaAereaDAO();
$vooDAO = new VooDAO();
$passagemDAO = new PassagemDAO();
$passageiroDAO = new PassageiroDAO();
$usuarioDAO = new UsuarioDAO();
$voo = $vooDAO->getById($data['id_voo']);
$user = $usuarioDAO->getById($data['id_comprador']);
$passageiro = $passageiroDAO->getById($data['passageiro']);
$passagem = new Passagem($user, $data['valor'], $passageiro, $voo->getCiaAerea(), new \DateTime($data['data']));
$trecho = new Trecho($voo, $passagem);
$passagem->addTrecho($trecho);
$request = $passagemDAO->create($passagem);

if ($request) {
    header('Location:/public/Pages/passagens.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
