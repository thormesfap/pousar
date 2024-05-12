<?php

namespace App\DAO;

use App\Entities\CiaAerea;
use App\Infra\Database\DatabaseManager;

class CiaAereaDAO
{
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }
    public function create(CiaAerea $cia): bool
    {

        $sql = "INSERT INTO cia_aerea (razao_social, cnpj, codigo_iata, telefone, email) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $cia->getRazaoSocial() ?? '');
        $stmt->bindValue(2, $cia->getCnpj() ?? '');
        $stmt->bindValue(3, $cia->getCodigoIata() ?? '');
        $stmt->bindValue(4, $cia->getTelefone() ?? '');
        $stmt->bindValue(5, $cia->getEmail() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    /**
     * @return CiaAerea[]
     */
    public function read(): array
    {

        $sql = "SELECT * FROM cia_aerea";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapCiaAerea'], $data);
    }
    public function getById(int $id): CiaAerea
    {
        $sql = "SELECT * FROM cia_aerea WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if (!$data) {
            return null;
        }
        return $this->mapCiaAerea($data);
    }
    public function update(CiaAerea $cia): bool
    {
        $sql = "UPDATE cia_aerea SET razao_social=?, cnpj=?, codigo_iata=?, telefone=?, email=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $cia->getRazaoSocial() ?? '');
        $stmt->bindValue(2, $cia->getCnpj() ?? '');
        $stmt->bindValue(3, $cia->getCodigoIata() ?? '');
        $stmt->bindValue(4, $cia->getTelefone() ?? '');
        $stmt->bindValue(5, $cia->getEmail() ?? '');
        $stmt->bindValue(6, $cia->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM cia_aerea WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function mapCiaAerea(object $dados): CiaAerea
    {
        $cia = new CiaAerea($dados->razao_social, $dados->cnpj, $dados->codigo_iata);
        $cia->setEmail($dados->email ?? null)->setTelefone($dados->telefone ?? '')->setId($dados->id);
        return $cia;
    }
}
