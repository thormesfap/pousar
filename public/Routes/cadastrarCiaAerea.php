<?php

use App\DAO\CiaAereaDAO;
use App\Entities\CiaAerea;

require '../../autoload.php';

//Pega os dados enviados do formulário
$data = $_POST;

//Cria companhia aérea com base nos dados enviados no formulário
$cia = new CiaAerea($data['razao_social'], $data['cnpj'], $data['iata']);

//Cria classe DAO para fazer a conexão com o banco de dados
$ciaDAO = new CiaAereaDAO();

//Seta os dados que não estão no construtor
$cia->setEmail($data['email'] ?? '');
$cia->setTelefone($data['telefone'] ?? '');

//Verifica se foi enviado o id da CiaAérea junto no formulário
if(isset($data['id']) && $data['id'] != ''){
    //Se foi enviado o id da companhia aérea, seta o id no objeto e a requisição é de atualização(update)
    $cia->setId($data['id']);
    $request = $ciaDAO->update($cia);
} else{
    //Se não tem id, é porque a requisição é para criação de companhia aérea (create)
    $request = $ciaDAO->create($cia);
}

//Se a requisição (create ou update) foi bem sucedida, retorna para a página de listagem de companhias aéreas. Se não, imprime erro na tela
if ($request) {
    header('Location:/public/Pages/cia_aerea.php');
} else {
    echo "Não foi possível realizar o cadastro da Cia Aérea";
}
