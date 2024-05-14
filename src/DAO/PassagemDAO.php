<?php

namespace App\DAO;

use App\Entities\Passagem;
use App\Infra\Database\DatabaseManager;

class PassagemDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Passagem $passagem): bool{
        
        $sql = "INSERT INTO passagem (valor, passageiro, trechos, ciaAerea) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passagem->getValor() ?? '');
        $stmt->bindValue(2, $passagem->getPassageiro() ?? '');
        $stmt->bindValue(3, $passagem->getTrechos() ?? '');
        $stmt->bindValue(4, $passagem->getCiaAerea() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    /**
     * @return Passagem[]
     */
    public function read(): array{
        
        $sql = "SELECT * FROM passagem";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapPassagem'], $data);
    }

    public function getById(int $id): ?Passagem{
        $sql = "SELECT * FROM passagem WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if(!$data){
            return null;
        }
        return $this->mapPassagem($data);
    }

    public function update(Passagem $passagem): bool{
        $sql = "UPDATE passagem SET valor=?, passageiro=?, trechos=?, ciaAerea=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passagem->getValor() ?? '');
        $stmt->bindValue(2, $passagem->getPassageiro() ?? '');
        $stmt->bindValue(3, $passagem->getTrechos() ?? '');
        $stmt->bindValue(4, $passagem->getCiaAerea() ?? '');
        $stmt->bindValue(5, $passagem->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM passagem WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
