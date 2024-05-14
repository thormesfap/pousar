<?php

namespace App\DAO;

use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

date_default_timezone_set('America/Sao_Paulo');

class UsuarioDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Usuario $usuario): bool{
        
        $sql = "INSERT INTO usuario (nome, email, cpf, telefone, senha, logradouro, numero_endereco, municipio, uf, data_hora_cadastro) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $usuario->getNome() ?? '');
        $stmt->bindValue(2, $usuario->getEmail() ?? '');
        $stmt->bindValue(3, $usuario->getCpf() ?? '');
        $stmt->bindValue(4, $usuario->getTelefone() ?? '');
        $stmt->bindValue(5, $usuario->getSenha() ?? '');
        $stmt->bindValue(6, $usuario->getLogradouro() ?? '');
        $stmt->bindValue(7, $usuario->getNumeroEndereco() ?? '');
        $stmt->bindValue(8, $usuario->getMunicipio() ?? '');
        $stmt->bindValue(9, $usuario->getUf() ?? '');
        $stmt->bindValue(10, (new \DateTime())->format("Y-m-d H:i:s"));
        return $stmt->execute();
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

    public function getByEmail(string $email):?Usuario{
        $sql = "SELECT * FROM usuario WHERE email=:email";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue('email', $email);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if (!$data) {
            return null;
        }
        return $this->mapUsuario($data);
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
        $sql = "UPDATE usuario SET nome=?, email=?, cpf=?, telefone=?, senha=?, logradouro=?, numero_endereco=?, municipio=?, uf=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $usuario->getNome() ?? '');
        $stmt->bindValue(2, $usuario->getEmail() ?? '');
        $stmt->bindValue(3, $usuario->getCpf() ?? '');
        $stmt->bindValue(4, $usuario->getTelefone() ?? '');
        $stmt->bindValue(5, $usuario->getSenha() ?? '');
        $stmt->bindValue(6, $usuario->getLogradouro() ?? '');
        $stmt->bindValue(7, $usuario->getNumeroEndereco() ?? '');
        $stmt->bindValue(8, $usuario->getMunicipio() ?? '');
        $stmt->bindValue(9, $usuario->getUf() ?? '');
        $stmt->bindValue(10, $usuario->getId() ?? '');
        return $stmt->execute();
    }

    public function delete(string $id): bool{
        $sql = "DELETE FROM usuario WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
    private function mapUsuario(object $dados): Usuario{
        $user = new Usuario($dados->email, $dados->nome);
        $user->setId($dados->id);
        $user->setCpf($dados->cpf ?? '');
        $user->setTelefone($dados->telefone ?? '');
        $user->setSenha($dados->senha);
        $user->setLogradouro($dados->logradouro ?? '');
        $user->setNumeroEndereco($dados->numero_endereco ?? '');
        $user->setMunicipio($dados->municipio ?? '');
        $user->setUf($dados-> uf ?? '');
        $user->setDataHoraCadastro(new \DateTimeImmutable($dados->data_hora_cadastro ?? ''));
        return $user;

    }
}
