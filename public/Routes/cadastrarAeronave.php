<?php

use App\Entities\Aeronave;
use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

require '../../autoload.php';

date_default_timezone_set('America/Sao_Paulo');
$data = $_POST;


$aero = new Aeronave($data['sigla'], $data['marca'], $data['fileira'], $data['assentos'], $data['prioritarios']);


//Substituir pelo AeronaveDAO->create()
$conn = DatabaseManager::getConn();
$sql = "INSERT INTO aeronave (sigla, marca, quantidade_fileiras, assentos_por_fila, assentos_prioritarios) VALUES (?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $aero->getSigla());
$stmt->bindValue(2, $aero->getMarca());
$stmt->bindValue(3, $aero->getQuantidadeFilas());
$stmt->bindValue(4, $aero->getAssentosFila());
$stmt->bindValue(5, $data['prioritarios']);
$stmt->execute();
if ($conn->rowCount() > 0) {
    header('Location:/public/Pages/aeronave.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
