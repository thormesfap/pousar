<?php

namespace App\DAO;

use App\Entities\Aeronave;
use App\Entities\CiaAerea;
use App\Entities\Passagem;
use App\Entities\Trecho;
use App\Entities\Voo;
use App\Infra\Database\DatabaseManager;
use ValueError;

class TrechoDAO
{
    private $conn;
    private $passagemDAO;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
        $this->passagemDAO = new PassagemDAO();
    }

    public function create(Trecho $trecho): bool
    {

        $sql = "INSERT INTO trecho (id_passagem, assento) VALUES(?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $trecho->getPassagem()->getId() ?? '');
        $stmt->bindValue(2, $trecho->getAssento() ?? '');
        return $stmt->execute();
    }
    /**
     * @return Trecho[]
     */
    public function read(int $idPassagem): array
    {
        $passagem = $this->passagemDAO->getById($idPassagem);
        if(!$passagem){
            throw new ValueError("Passagem com id $idPassagem não encontrada");
        }
        $sql = "SELECT * FROM trecho INNER JOIN trecho_voo ON trecho_voo.id_trecho=trecho.id INNER JOIN voo ON voo.id=trecho_voo.id INNER JOIN cia_aerea ON voo.id_companhia=cia_aerea.id INNER JOIN aeronave ON aeronave.id=voo.id_aeronave WHERE id_passagem=?;";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $idPassagem);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        foreach($data as $dados){
            $dados->passagem = $passagem;
        }
        return array_map([$this, 'mapTrecho'], $data);
    }

    public function getById(int $id): ?Trecho
    {
        $sql = "SELECT * FROM trecho INNER JOIN trecho_voo ON trecho_voo.id_trecho=trecho.id INNER JOIN voo ON voo.id=trecho_voo.id INNER JOIN cia_aerea ON voo.id_companhia=cia_aerea.id INNER JOIN aeronave ON aeronave.id=voo.id_aeronave WHERE trecho.id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if (!$data) {
            return null;
        }
        return $this->mapTrecho($data);
    }

    public function update(Trecho $trecho): bool
    {
        $sql = "UPDATE trecho SET id_passagem=?, assento=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $trecho->getPassagem()->getId() ?? '');
        $stmt->bindValue(2, $trecho->getAssento() ?? '');
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM trecho WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    private function mapTrecho(object $dados): Trecho
    {
        $passagem = $dados->passagem;
        $cia = new CiaAerea($dados->razao_social, $dados->cnpj, $dados->codigo_iata);
        $cia->setId($dados->id_companhia);
        $aeronave = new Aeronave($dados->sigla, $dados->marca, $dados->quantidade_fileiras, $dados->assentos_por_fila, $dados->assentos_prioritarios);
        $aeronave->setId($dados->id_aeronave);
        $voo = new Voo($dados->numero, $dados->cod_origem, $dados->cod_destino, $aeronave, $cia);
        $trecho = new Trecho($voo, $passagem);
        if($dados->assento){
            $trecho->marcarAssento($dados->assento, $passagem->getPassageiro());
        }
        $trecho->setId($dados->id_trecho);
        return $trecho;
    }
}
