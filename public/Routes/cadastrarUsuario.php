<?php

use App\DAO\UsuarioDAO;
use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

require dirname(__DIR__) . '../../autoload.php';


$data = $_POST;

$user = new Usuario($data['email'], $data['nome']);
$user->setSenha(password_hash($data['senha'], PASSWORD_BCRYPT));
$user->setCpf($data['cpf'] ?? '');
$user->setTelefone($data['telefone'] ?? '');
$user->setLogradouro($data['logradouro'] ?? '');
$user->setNumeroEndereco($data['numero'] ?? '');
$user->setUf($data['uf'] ?? '');
$user->setMunicipio($data['municipio'] ?? '');

$usuarioDAO = new UsuarioDAO();
$request = $usuarioDAO->create($user);
if ($request) {
    header('Location:/public/Pages/login.php');
} else {
    echo "Não foi possível realizar o cadastro do usuário";
}
