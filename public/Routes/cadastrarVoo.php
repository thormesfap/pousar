<?php

use App\DAO\AeronaveDAO;
use App\DAO\CiaAereaDAO;
use App\DAO\VooDAO;
use App\Entities\Voo;
use App\Infra\Database\DatabaseManager;

require '../../autoload.php';

$data = $_POST;

$aeroDAO = new AeronaveDAO();
$ciaDAO = new CiaAereaDAO();
$vooDAO = new VooDAO();
$cia = $ciaDAO->getById($data['cia_aerea']);
$aero = $aeroDAO->getById($data['aeronave']);
$voo = new Voo($data['numero'], $data['cod_origem'], $data['cod_destino'], $aero, $cia);
$voo->setHoraSaida($data['hora_saida']);
$voo->setHoraChegada($data['hora_chegada']);

if(isset($data['id']) && $data['id'] != ''){
    $voo->setId($data['id']);
    $request = $vooDAO->update($voo);
} else{
    $request = $vooDAO->create($voo);
}

if ($request) {
    header('Location:/public/Pages/voo.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
