<?php

namespace App\DAO;

use App\Entities\Voo;
use App\Infra\Database\DatabaseManager;

class VooDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Voo $voo): bool{
        
        $sql = "INSERT INTO voo (numero, codOrigem, codDestino, aeronave, ciaAerea) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $voo->getNumero() ?? '');
        $stmt->bindValue(2, $voo->getCodigoOrigem() ?? '');
        $stmt->bindValue(3, $voo->getCodigoDestino() ?? '');
        $stmt->bindValue(4, $voo->getAeronave() ?? '');
        $stmt->bindValue(5, $voo->getCiaAerea() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

        /**
     * @return Voo[]
     */
    public function read(): array{
        
        $sql = "SELECT * FROM voo";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapVoo'], $data);
    }

    public function getById(int $id): ?Voo{
        $sql = "SELECT * FROM voo WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if(!$data){
            return null;
        }
        return $this->mapVoo($data);
    }

    public function update(Voo $voo): bool{
        $sql = "UPDATE voo SET numero=?, codOrigem=?, codDestino=?, aeronave=?, ciaAerea=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $voo->getNumero() ?? '');
        $stmt->bindValue(2, $voo->getCodigoOrigem() ?? '');
        $stmt->bindValue(3, $voo->getCodigoDestino() ?? '');
        $stmt->bindValue(4, $voo->getAeronave() ?? '');
        $stmt->bindValue(5, $voo->getCiaAerea() ?? '');
        $stmt->bindValue(6, $voo->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM voo WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

}
