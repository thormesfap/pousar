<?php

namespace App\DAO;

use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

class UsuarioDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Usuario $usuario): bool{
        
        $sql = "INSERT INTO usuario (nome, cpf, telefone, senha, logradouro, numeroEndereco, municipio, uf, dataHoraCadastro) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $usuario->getNome() ?? '');
        $stmt->bindValue(2, $usuario->getCpf() ?? '');
        $stmt->bindValue(3, $usuario->getTelefone() ?? '');
        $stmt->bindValue(4, $usuario->getSenha() ?? '');
        $stmt->bindValue(5, $usuario->getLogradouro() ?? '');
        $stmt->bindValue(6, $usuario->getNumeroEndereco() ?? '');
        $stmt->bindValue(7, $usuario->getMunicipio() ?? '');
        $stmt->bindValue(8, $usuario->getUf() ?? '');
        $stmt->bindValue(9, $usuario->getDataHoraCadastro() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    /**
     * @return Usuario[]
     */
    public function read(): array{
        
        $sql = "SELECT * FROM usuario";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapUsuario'], $data);
    }

    public function getById(int $id): ?Usuario{
        $sql = "SELECT * FROM usuario WHERE id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if(!$data){
            return null;
        }
        return $this->mapUsuario($data);
    }

    public function update(Usuario $usuario): bool{
        $sql = "UPDATE usuario SET nome=?, cpf=?, telefone=?, senha=?, logradouro=?, numeroEndereco=?, municipio=?, uf=?, dataHoraCadastro=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $usuario->getNome() ?? '');
        $stmt->bindValue(2, $usuario->getCpf() ?? '');
        $stmt->bindValue(3, $usuario->getTelefone() ?? '');
        $stmt->bindValue(4, $usuario->getSenha() ?? '');
        $stmt->bindValue(5, $usuario->getLogradouro() ?? '');
        $stmt->bindValue(6, $usuario->getNumeroEndereco() ?? '');
        $stmt->bindValue(7, $usuario->getMunicipio() ?? '');
        $stmt->bindValue(8, $usuario->getUf() ?? '');
        $stmt->bindValue(9, $usuario->getDataHoraCadastro() ?? '');
        $stmt->bindValue(10, $usuario->getId() ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM usuario WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
