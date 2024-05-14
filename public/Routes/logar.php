<?php

use App\DAO\UsuarioDAO;

require dirname(__DIR__) . '../../autoload.php';



$data = $_POST;

$email = $data['email'];
$senha = $data['senha'];
$dao = new UsuarioDAO();
$user = $dao->getByEmail($email);
if(!$user) {
    echo "usuario não encontrado";
} else {
    $passou = password_verify($senha, $user->getSenha());
    if ($passou) {
        session_start();
        $_SESSION['user'] = $user;
        header("Location:/index.php");
    } else {
        echo "Senha errada";
    }
}
