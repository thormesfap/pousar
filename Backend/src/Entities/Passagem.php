<?php

namespace App\Entities;

class Passagem{
    private float $valor;
    private Passageiro $passageiro;
    private array $trechos;

    public function __construct(float $valor, Passageiro $passageiro)
    {
        $this->valor = $valor;
        $this->passageiro = $passageiro;
        $this->trechos = [];
    }

    public function getValor(): float
    {
        return $this->valor;
    }
    public function getPassageiro(): Passageiro
    {
        return $this->passageiro;
    }
    public function getTrechos(): array{
        return $this->trechos;
    }
    public function addTrecho(Trecho $trecho){
        $this->trechos[] = $trecho;
    }


}