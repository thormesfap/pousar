<?php

namespace App\DAO;

use App\Entities\Passageiro;
use App\Infra\Database\DatabaseManager;

class PassageiroDAO
{
    private $conn;
    private $userDAO;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
        $this->userDAO = new UsuarioDAO();
    }

    public function create(Passageiro $passageiro): bool{
        
        $sql = "INSERT INTO passageiro (nome, cpf, email, telefone, telefone_contato, id_usuario) VALUES(?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passageiro->getNome() ?? '');
        $stmt->bindValue(2, $passageiro->getCpf() ?? '');
        $stmt->bindValue(3, $passageiro->getEmail() ?? '');
        $stmt->bindValue(4, $passageiro->getTelefone() ?? '');
        $stmt->bindValue(5, $passageiro->getTelefoneContato() ?? '');
        $stmt->bindValue(6, $passageiro->getUsuario()->getId() ?? null);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    /**
     * @return Passageiro[]
     */
    public function read(): array{
        
        $sql = "SELECT * FROM passageiro";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapPassageiro'], $data);
    }

    public function getById(int $id): ?Passageiro{
        $sql = "SELECT * FROM passageiro WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if(!$data){
            return null;
        }
        return $this->mapPassageiro($data);
    }
    
    public function update(Passageiro $passageiro): bool{
        $sql = "UPDATE passageiro SET nome=?, cpf=?, email=?, telefone=?, telefone_contato=?, id_usuario=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passageiro->getNome() ?? '');
        $stmt->bindValue(2, $passageiro->getCpf() ?? '');
        $stmt->bindValue(3, $passageiro->getEmail() ?? '');
        $stmt->bindValue(4, $passageiro->getTelefone() ?? '');
        $stmt->bindValue(5, $passageiro->getTelefoneContato() ?? '');
        $stmt->bindValue(6, $passageiro->getUsuario()->getId() ?? '');
        $stmt->bindValue(7, $passageiro->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM passageiro WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function mapPassageiro(object $dados):Passageiro{
        $pass = new Passageiro($dados->nome, $dados->cpf, $dados->telefone);
        $pass->setEmail($dados->email ?? null)->setTelefoneContato($dados->telefone_contato ?? '')->setId($dados->id);
        $user = $this->userDAO->getById($dados->id_usuario);
        $pass->setUsuario($user);
        return $pass;
    }
}