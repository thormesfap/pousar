<?php

namespace App\DAO;

use App\Entities\CiaAerea;
use App\Entities\Passageiro;
use App\Entities\Passagem;
use App\Entities\Usuario;
use App\Infra\Database\DatabaseManager;

class PassagemDAO {
    private $conn;
    private $trechoDAO;
    public function __construct()
    {
        $this->trechoDAO = new TrechoDAO();
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Passagem $passagem): bool{
        
        $sql = "INSERT INTO passagem (valor, id_usuario_comprador, id_passageiro, id_cia_aerea, data_saida, data_compra) VALUES(?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passagem->getValor() ?? '');
        $stmt->bindValue(2, $passagem->getComprador()->getId() ?? '');
        $stmt->bindValue(3, $passagem->getPassageiro()->getId() ?? '');
        $stmt->bindValue(4, $passagem->getCiaAerea()->getId() ?? '');
        $stmt->bindValue(5, $passagem->getDataSaida()->format("Y-m-d") ?? '');
        $stmt->bindValue(6, $passagem->getDataCompra()->format("Y-m-d H:i:s") ?? '');
        $stmt->execute();
        if($stmt->rowCount() == 0){
            return false;
        }
        $id = $this->conn->lastInsertId();
        $passagem->setId($id);
        foreach($passagem->getTrechos() as $trecho){
            if(!$this->trechoDAO->create($trecho)){
                return false;
            }
        }
        return true;
        
    }
    /**
     * @return Passagem[]
     */
    public function read(): array{
        
        $sql = "SELECT *, passagem.id as id_passagem, usuario.email as email_usuario, usuario.telefone as telefone_usuario, usuario.nome as nome_usuario FROM passagem INNER JOIN usuario ON usuario.id=passagem.id_usuario_comprador INNER JOIN passageiro ON passageiro.id=passagem.id_passageiro INNER JOIN cia_aerea ON cia_aerea.id=passagem.id_cia_aerea";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapPassagem'], $data);
    }

    public function getById(int $id): ?Passagem{
        $sql = "SELECT *, passagem.id as id_passagem, usuario.email as email_usuario, usuario.telefone as telefone_usuario, usuario.nome as nome_usuario, usuario.cpf as cpf_usuario FROM passagem INNER JOIN usuario ON usuario.id=passagem.id_usuario_comprador INNER JOIN passageiro ON passageiro.id=passagem.id_passageiro INNER JOIN cia_aerea ON cia_aerea.id=passagem.id_cia_aerea WHERE id_passagem=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);
        if(!$data){
            return null;
        }
        return $this->mapPassagem($data);
    }

    /**
     * @return Passagem[]
     */

    public function getByUsuarioId(int $id): array
    {
        $sql = "SELECT *, passagem.id as id_passagem, usuario.email as email_usuario, usuario.telefone as telefone_usuario, usuario.nome as nome_usuario, usuario.cpf as cpf_usuario FROM passagem INNER JOIN usuario ON usuario.id=passagem.id_usuario_comprador INNER JOIN passageiro ON passageiro.id=passagem.id_passageiro INNER JOIN cia_aerea ON cia_aerea.id=passagem.id_cia_aerea WHERE usuario.id=?";
        $stmt = $this->conn->query($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        if (count($data) == 0) {
            return [];
        }
        return array_map([$this, 'mapPassagem'], $data);
    }

    public function update(Passagem $passagem): bool{
        $sql = "UPDATE passagem SET valor=?, id_passageiro=?, id_cia_aerea=?, id_usuario_comprador=?, data_saida=?, data_compra=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $passagem->getValor() ?? '');
        $stmt->bindValue(2, $passagem->getPassageiro()->getId() ?? '');
        $stmt->bindValue(3, $passagem->getCiaAerea()->getId() ?? '');
        $stmt->bindValue(4, $passagem->getComprador()->getId() ?? '');
        $stmt->bindValue(4, $passagem->getDataSaida()->format("Y-m-d") ?? '');
        $stmt->bindValue(4, $passagem->getDataCompra()->format("Y-m-d H:i:s") ?? '');
        $stmt->bindValue(7, $passagem->getId() ?? '');
        return $stmt->execute();
    }

    public function delete(int $id): bool{
        $sql = "DELETE FROM passagem WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    private function mapPassagem(object $dados): Passagem{
        $user = new Usuario($dados->email_usuario, $dados->nome_usuario);
        $user->setId($dados->id_usuario_comprador);
        $cia = new CiaAerea($dados->razao_social, $dados->cnpj, $dados->codigo_iata);
        $cia->setId($dados->id_cia_aerea);
        $passageiro = new Passageiro($dados->nome, $dados->cpf, $dados->telefone);
        $passageiro->setId($dados->id_passageiro);
        $passagem = new Passagem($user, $dados->valor, $passageiro, $cia, new \DateTime($dados->data_saida));
        $passagem->setId($dados->id_passagem);
        $passagem->setdatacompra(new \DateTimeImmutable($dados->data_compra));
        $trechos = $this->trechoDAO->read($passagem);
        foreach($trechos as $trecho){
            $passagem->addTrecho($trecho);
        }
        return $passagem;
    }
}
