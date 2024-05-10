<?php
use App\Infra\Database\DatabaseManager;

require dirname(__DIR__) . '../../autoloader.php';

$conn = DatabaseManager::getInstance();

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
        header("Location:cadastro.php");
    } else {
        echo "Senha errada";
    }
}



