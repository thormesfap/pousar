<?php

namespace App\Entities;

class Passagem extends Entity
{
    private float $valor;
    private Passageiro $passageiro;
    /**
     * @var Trecho[] $trechos
     */
    private array $trechos;
    private CiaAerea $ciaAerea;
    private Usuario $comprador;
    private \DateTimeInterface $dataSaida;
    private \DateTimeImmutable $datacompra;

    public function __construct(Usuario $comprador, float $valor, Passageiro $passageiro, CiaAerea $ciaAerea, \DateTimeInterface $dataSaida)
    {
        $this->valor = $valor;
        $this->passageiro = $passageiro;
        $this->ciaAerea = $ciaAerea;
        $this->comprador = $comprador;
        $this->dataSaida = $dataSaida;
        $this->datacompra = new \DateTimeImmutable();
        $this->trechos = [];
    }

    public function getOrigem(){
        if(count($this->trechos) > 0){
            return $this->trechos[0]->getVoo()->getCodigoOrigem();
        }
        return '';
    }

    public function getDestino(){
        if (count($this->trechos) > 0) {
            return end($this->trechos)->getVoo()->getCodigoDestino();
        }
        return '';
    }
    public function getValor(): float
    {
        return $this->valor;
    }
    public function getComprador(): Usuario
    {
        return $this->comprador;
    }
    public function getPassageiro(): Passageiro
    {
        return $this->passageiro;
    }
    public function getTrechos(): array
    {
        return $this->trechos;
    }
    public function getDataSaida(): \DateTimeInterface
    {
        return $this->dataSaida;
    }

    public function getDataCompra(): \DateTimeImmutable
    {
        return $this->datacompra;
    }
    public function setdatacompra(\DateTimeImmutable $dataCompra): self{
        $this->datacompra = $dataCompra;
        return $this;
    }

    //Adiciona cada trechos
    public function addTrecho(Trecho $trecho)
    {
        $this->trechos[] = $trecho;
    }
    public function getCiaAerea()
    {
        return $this->ciaAerea;
    }
}
