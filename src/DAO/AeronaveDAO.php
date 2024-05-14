<?php

namespace App\DAO;

use App\Entities\Aeronave;
use App\Infra\Database\DatabaseManager;
use PDO;

class AeronaveDAO {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = DatabaseManager::getInstance();
    }

    public function inserir(Aeronave $aeronave): bool {
        $sql = "INSERT INTO aeronave (sigla, quantidade_assentos, quantidade_fileiras, assentos_por_fila, assentos_prioritarios) 
                VALUES (:sigla, :quantidade_assentos, :quantidade_fileiras, :assentos_por_fila, :assentos_prioritarios)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':sigla', $aeronave->getSigla());
        $stmt->bindValue(':quantidade_assentos', $aeronave->getQteAssentos());
        $stmt->bindValue(':quantidade_fileiras', $aeronave->getQuantidadeFilas());
        $stmt->bindValue(':assentos_por_fila', $aeronave->getAssentosFila());
        $stmt->bindValue(':assentos_prioritarios', $aeronave->getAssentosPrioritarios()); 

        return $stmt->execute();
    }

    private function criarAeronave(array $data): Aeronave {
        return new Aeronave(
            $data['sigla'], 
            $data['quantidade_fileiras'],
            $data['assentos_por_fila'],
            $data['assentos_prioritarios']
        );
    }
    public function buscarPorId(int $id): ?Aeronave {
        $sql = "SELECT * FROM aeronave WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $this->criarAeronave($row); 
        }
        return null;
    }

    public function listarTodos(): array {
        $sql = "SELECT * FROM aeronave";
        $stmt = $this->conexao->query($sql);
        $aeronaves = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $aeronaves[] = $this->criarAeronave($row); 
        }
        return $aeronaves;
    }

    public function atualizar(Aeronave $aeronave): bool {
        $sql = "UPDATE aeronave SET sigla = :sigla, quantidade_assentos = :quantidade_assentos, quantidade_fileiras = :quantidade_fileiras, assentos_por_fila = :assentos_por_fila, assentos_prioritarios = :assentos_prioritarios
                WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':sigla', $aeronave->getSigla());
        $stmt->bindValue(':quantidade_assentos', $aeronave->getQteAssentos());
        $stmt->bindValue(':quantidade_fileiras', $aeronave->getQuantidadeFilas());
        $stmt->bindValue(':assentos_por_fila', $aeronave->getAssentosFila());
        $stmt->bindValue(':assentos_prioritarios', $aeronave->getAssentosPrioritarios());
        $stmt->bindValue(':id', $aeronave->getId());
        return $stmt->execute();
    }

    public function excluir(int $id): bool {
        $sql = "DELETE FROM aeronave WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }

    //para criar um objeto Aeronave a partir dos dados do banco
    private function criarAeronave(array $data): Aeronave {
        return new Aeronave(
            $data['sigla'], 
            $data['quantidade_fileiras'],
            $data['assentos_por_fila'],
            $data['assentos_prioritarios']
        );
    }
}

/*namespace App\DAO;

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
//