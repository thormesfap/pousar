<?php

use App\Entities\Voo;
use App\Infra\Database\DatabaseManager;

require '../../autoload.php';

$data = $_POST;


//Substituir pelo VooDAO->create()
$conn = DatabaseManager::getConn();
$sql = "INSERT INTO voo (numero, cod_origem, cod_destino, id_aeronave, id_companhia) VALUES (?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $data['numero']);
$stmt->bindValue(2, $data['cod_origem']);
$stmt->bindValue(3, $data['cod_destino']);
$stmt->bindValue(4, $data['aeronave']);
$stmt->bindValue(5, $data['cia_aerea']);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    header('Location:/public/Pages/voo.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
