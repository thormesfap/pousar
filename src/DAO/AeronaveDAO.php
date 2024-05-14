<?php

namespace App\DAO;

use App\Entities\Aeronave;
use App\Infra\Database\DatabaseManager;

class AeronaveDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }
    public function create(Aeronave $aeronave): bool{
        
        $sql = "INSERT INTO passageiro (sigla, marca, qtdFileiras, assentosPorFila) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $aeronave->getSigla() ?? '');
        $stmt->bindValue(2, $aeronave->marca() ?? '');
        $stmt->bindValue(3, $aeronave->getQuantidadeFilas() ?? '');
        $stmt->bindValue(4, $aeronave->getAssentosFila() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    /**
     * @return Passageiro[]
     */
    public function read(): array{
        
        $sql = "SELECT * FROM aeronave";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapAeronave'], $data); 
    }

    public function getById(int $id): ?Aeronave
    {
        $sql = "SELECT * FROM aeronave WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if (!$data) {
            return null;
        }
        return $this->mapAeronave($data);
    }

    public function update(Aeronave $aeronave): bool{
        $sql = "UPDATE aeronave SET sigla=?, marca=?, qtdFileiras=?, assentosPorFila=?, WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $aeronave->getSigla() ?? '');
        $stmt->bindValue(2, $aeronave->getMarca() ?? '');
        $stmt->bindValue(3, $aeronave->getQuantidadeFilas() ?? '');
        $stmt->bindValue(4, $aeronave->getAssentosFila() ?? '');
        $stmt->bindValue(5, $aeronave->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM aeronave WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
