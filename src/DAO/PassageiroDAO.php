<?php

namespace App\DAO;

use App\Entities\Passageiro;
use App\Infra\Database\DatabaseManager;

class PassageiroDAO
{
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }
    public function create(Passageiro $passageiro){
        
        $sql = "INSERT INTO passageiro (nome, cpf, email, telefone, telefone_contato) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passageiro->getNome() ?? '');
        $stmt->bindValue(2, $passageiro->getCpf() ?? '');
        $stmt->bindValue(3, $passageiro->getEmail() ?? '');
        $stmt->bindValue(4, $passageiro->getTelefone() ?? '');
        $stmt->bindValue(5, $passageiro->getTelefoneContato() ?? '');
        $stmt->execute();
    }
    /**
     * @return Passageiro[]
     */
    public function read(){
        
        $sql = "SELECT * FROM passageiro";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapPassageiro'], $data);
        
    }
    public function getById(int $id){
        $sql = "SELECT * FROM passageiro WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        return $this->mapPassageiro($data);
    }
    public function update(Passageiro $passageiro){
        $sql = "UPDATE passageiro SET nome=?, cpf=?, email=?, telefone=?, telefone_contato=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passageiro->getNome() ?? '');
        $stmt->bindValue(2, $passageiro->getCpf() ?? '');
        $stmt->bindValue(3, $passageiro->getEmail() ?? '');
        $stmt->bindValue(4, $passageiro->getTelefone() ?? '');
        $stmt->bindValue(5, $passageiro->getTelefoneContato() ?? '');
        $stmt->bindValue(6, $passageiro->getId() ?? '');
        $stmt->execute();
    }
    public function delete(int $id){
        $sql = "DELETE FROM passageiro WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    private function mapPassageiro(object $dados):Passageiro{
        $pass = new Passageiro($dados->nome, $dados->cpf, $dados->telefone);
        $pass->setEmail($dados->email ?? null)->setTelefoneContato($dados->telefone_contato ?? '')->setId($dados->id);
        return $pass;
    }
}