<?php

use App\DAO\PassageiroDAO;
use App\DAO\UsuarioDAO;
use App\Entities\Passageiro;

require '../../autoload.php';

$data = $_POST;
$passageiroDAO = new PassageiroDAO();
$userDAO = new UsuarioDAO();
$user = $userDAO->getById($data['id_usuario']);
$passageiro = new Passageiro($data['nome'], $data['cpf'], $data['telefone']);
$passageiro->setEmail($data['email'] ?? '');
$passageiro->setTelefoneContato($data['telefone_contato'] ?? '');
$passageiro->setUsuario($user);

if (isset($data['id']) && $data['id'] != '') {
    $passageiro->setId($data['id']);
    $request = $passageiroDAO->update($passageiro);
} else {
    $request = $passageiroDAO->create($passageiro);
}

if ($request) {
    header('Location:/public/Pages/passageiro.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
