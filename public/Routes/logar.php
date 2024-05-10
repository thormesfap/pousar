<?php

use App\Infra\Database\DatabaseManager;

require dirname(__DIR__) . '../../autoload.php';

$conn = DatabaseManager::getConn();

$data = $_POST;

$email = $data['email'];
$senha = $data['senha'];
$sql = "SELECT * FROM usuario WHERE email=:email";
$result = $conn->query($sql);
$result->bindValue('email', $email);
$result->execute();
$all = $result->fetchAll(PDO::FETCH_OBJ);
if (count($all) == 0) {
    echo "usuario não encontrado";
} else {
    $passou = password_verify($senha, $all[0]->senha);
    if ($passou) {
        session_start();
        $_SESSION['user'] = $email;
        header("Location:/index.php");
    } else {
        echo "Senha errada";
    }
}
