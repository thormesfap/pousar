<?php

use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

require dirname(__DIR__) . '../../autoloader.php';

date_default_timezone_set('America/Sao_Paulo');
$data = $_POST;

$user = new Usuario($data['email'], $data['nome']);
$user->setSenha(password_hash($data['senha'], PASSWORD_BCRYPT));
$user->setCpf($data['cpf'] ?? '');
$user->setTelefone($data['telefone'] ?? '');
$user->setLogradouro($data['logradouro'] ?? '');
$user->setNumeroEndereco($data['numero'] ?? '');
$user->setUf($data['uf'] ?? '');
$user->setMunicipio($data['municipio'] ?? '');

$conn = DatabaseManager::getConn();

$sql = "INSERT INTO usuario (email, senha, nome, cpf, telefone, logradouro, numero_endereco, uf, municipio, data_hora_cadastro) VALUES (?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $user->getEmail());
$stmt->bindValue(2, $user->getSenha());
$stmt->bindValue(3, $user->getNome());
$stmt->bindValue(4, $user->getCpf());
$stmt->bindValue(5, $user->getTelefone());
$stmt->bindValue(6, $user->getLogradouro());
$stmt->bindValue(7, $user->getNumeroEndereco());
$stmt->bindValue(8, $user->getUf());
$stmt->bindValue(9, $user->getMunicipio());
$stmt->bindValue(10, (new \DateTime())->format("Y-m-d H:i:s"));
$stmt->execute();
if ($conn->lastInsertId()) {
    header('Location:index.php');
} else {
    echo "Não foi possível realizar o cadastro do usuário";
}
