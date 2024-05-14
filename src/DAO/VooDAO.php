<?php

namespace App\DAO;

use App\Infra\Database\DatabaseManager;
use App\Entities\Voo;
use App\Entities\CiaAerea;
use App\Entities\Aeronave;

class VooDAO {
    private $conn;
    public function __construct()
    {
        $this->conn = DatabaseManager::getConn();
    }

    public function create(Voo $voo): bool{
        
        $sql = "INSERT INTO voo (numero, cod_origem, cod_destino, id_aeronave, id_companhia, data_hora_saida, data_hora_chegada) VALUES(?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $voo->getNumero() ?? '');
        $stmt->bindValue(2, $voo->getCodigoOrigem() ?? '');
        $stmt->bindValue(3, $voo->getCodigoDestino() ?? '');
        $stmt->bindValue(4, $voo->getAeronave()->getId() ?? '');
        $stmt->bindValue(5, $voo->getCiaAerea()->getId() ?? '');
        $stmt->bindValue(6, $voo->getHoraSaida() ?? '');
        $stmt->bindValue(7, $voo->getHoraChegada() ?? '');
        return $stmt->execute();
    }

        /**
     * @return Voo[]
     */
    public function read(): array{
        
        $sql = "SELECT *, voo.id as id_voo FROM voo INNER JOIN aeronave ON voo.id_aeronave=aeronave.id INNER JOIN cia_aerea on cia_aerea.id=voo.id_companhia";
        $stmt = $this->conn->query($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return array_map([$this, 'mapVoo'], $data);
    }

    public function getById(int $id): ?Voo{
        $sql = "SELECT *, voo.id as id_voo FROM voo INNER JOIN aeronave ON voo.id_aeronave=aeronave.id INNER JOIN cia_aerea on cia_aerea.id=voo.id_companhia WHERE voo.id=?";
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
        $sql = "UPDATE voo SET numero=?, cod_origem=?, cod_destino=?, id_aeronave=?, id_companhia=?, data_hora_saida=?, data_hora_chegada=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(1, $voo->getNumero() ?? '');
        $stmt->bindValue(2, $voo->getCodigoOrigem() ?? '');
        $stmt->bindValue(3, $voo->getCodigoDestino() ?? '');
        $stmt->bindValue(4, $voo->getAeronave()->getId() ?? '');
        $stmt->bindValue(5, $voo->getCiaAerea()->getId() ?? '');
        $stmt->bindValue(6, $voo->getHoraSaida() ?? '');
        $stmt->bindValue(7, $voo->getHoraChegada() ?? '');
        $stmt->bindValue(8, $voo->getId() ?? '');
        return $stmt->execute();
    }

    public function delete(string $id): bool{
        $sql = "DELETE FROM voo WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    private function mapVoo(object $data): Voo
    {
        $cia = new CiaAerea($data->razao_social, $data->cnpj, $data->codigo_iata);
        $cia->setId($data->id_companhia);
        $aeronave = new Aeronave($data->sigla, $data->marca, $data->quantidade_fileiras, $data->assentos_por_fila, $data->assentos_prioritarios);
        $aeronave->setId($data->id_aeronave);
        $voo = new Voo($data->numero, $data->cod_origem, $data->cod_destino, $aeronave, $cia);
        $voo->setHoraSaida($data->data_hora_saida);
        $voo->setHoraChegada($data->data_hora_chegada);
        $voo->setId($data->id_voo);
        return $voo;
    }

}
