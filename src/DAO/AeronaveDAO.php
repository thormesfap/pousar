<?php

namespace App\DAO;

use App\Entities\Aeronave;
use App\Infra\Database\DatabaseManager;
use PDO;

class AeronaveDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = DatabaseManager::getConn();
    }

    public function create(Aeronave $aeronave): bool {
        $sql = "INSERT INTO aeronave (sigla,marca, quantidade_fileiras, assentos_por_fila, assentos_prioritarios) 
                VALUES (:sigla, :marca, :quantidade_fileiras, :assentos_por_fila, :assentos_prioritarios)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':sigla', $aeronave->getSigla());
        $stmt->bindValue(':marca', $aeronave->getMarca());
        $stmt->bindValue(':quantidade_fileiras', $aeronave->getQuantidadeFilas());
        $stmt->bindValue(':assentos_por_fila', $aeronave->getAssentosFila());
        $stmt->bindValue(':assentos_prioritarios', $aeronave->getAssentosPrioritarios()); 
        return $stmt->execute();
    }

    public function getById(int $id): ?Aeronave {
        $sql = "SELECT * FROM aeronave WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            return $this->mapAeronave($row); 
        }
        return null;
    }

    public function read(): array {
        $sql = "SELECT * FROM aeronave";
        $stmt = $this->conexao->query($sql);
        $aeronaves = [];
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            $aeronaves[] = $this->mapAeronave($row); 
        }
        return $aeronaves;
    }

    public function update(Aeronave $aeronave): bool {
        $sql = "UPDATE aeronave SET sigla = :sigla, marca=:marca, quantidade_fileiras = :quantidade_fileiras, assentos_por_fila = :assentos_por_fila, assentos_prioritarios = :assentos_prioritarios
                WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':sigla', $aeronave->getSigla());
        $stmt->bindValue(':marca', $aeronave->getMarca());
        $stmt->bindValue(':quantidade_fileiras', $aeronave->getQuantidadeFilas());
        $stmt->bindValue(':assentos_por_fila', $aeronave->getAssentosFila());
        $stmt->bindValue(':assentos_prioritarios', $aeronave->getAssentosPrioritarios());
        $stmt->bindValue(':id', $aeronave->getId());
        return $stmt->execute();
    }

    public function delete(string $id): bool {
        $sql = "DELETE FROM aeronave WHERE id=:id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function mapAeronave(object $data): Aeronave
    {
        $aero = new Aeronave(
            $data->sigla,
            $data->marca,
            $data->quantidade_fileiras,
            $data->assentos_por_fila,
            $data->assentos_prioritarios
        );
        $aero->setId($data->id);
        return $aero;
    }

}