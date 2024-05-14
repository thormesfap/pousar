<?php

use App\DAO\AeronaveDAO;
use App\Entities\Aeronave;

require '../../autoload.php';

$data = $_POST;
$aeroDAO = new AeronaveDAO();
$aero = new Aeronave($data['sigla'], $data['marca'], $data['fileira'], $data['assentos'], $data['prioritarios']);

if(isset($data['id']) && $data['id'] != ''){
    $aero->setId($data['id']);
    $request = $aeroDAO->update($aero);
} else{
    $request = $aeroDAO->create($aero);
}

if ($request) {
    header('Location:/public/Pages/aeronave.php');
} else {
    echo "Não foi possível realizar o cadastro da aeronave";
}
