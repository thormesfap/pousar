<?php

use App\Entities\Aeronave;
use App\Entities\CiaAerea;
use App\Infra\Database\DatabaseManager;

require '../../autoload.php';

$data = $_POST;

$cia = new CiaAerea($data['razao_social'], $data['cnpj'], $data['iata']);
$cia->setEmail($data['email'] ?? '');
$cia->setTelefone($data['telefone'] ?? '');

//Substituir pelo CiaAereaDAO->create()
$conn = DatabaseManager::getConn();
$sql = "INSERT INTO cia_aerea (razao_social, cnpj, codigo_iata, email, telefone) VALUES (?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $cia->getRazaoSocial());
$stmt->bindValue(2, $cia->getCnpj());
$stmt->bindValue(3, $cia->getCodigoIata());
$stmt->bindValue(4, $cia->getEmail());
$stmt->bindValue(5, $cia->getTelefone());
$stmt->execute();
if ($stmt->rowCount() > 0) {
    header('Location:/public/Pages/cia_aerea.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
