<?php

namespace App\Entities;

use ValueError;

class Trecho extends Entity
{
    private Assento $assento;
    private Voo $voo;
    private Passagem $passagem;

    public function __construct(Voo $voo, Passagem $passagem)
    {
        $this->voo = $voo;
        $this->passagem = $passagem;
    }
    public function getVoo(): Voo
    {
        return $this->voo;
    }
    public function getPassagem(): Passagem
    {
        return $this->passagem;
    }
    public function getAssento(): ?string
    {
        return $this->assento->getCodigo() ?? null;
    }

    public function marcarAssento(string $codigo, Passageiro $passageiro)
    {
        if ($passageiro->getCpf() != $this->passagem->getPassageiro()->getCpf()) {
            throw new ValueError("A passagem deste trecho não pertence ao passageiro");
        }
        $this->voo->ocuparAssento($codigo, $passageiro);
    }

    public function desmarcarAssento(Passageiro $passageiro)
    {
        if ($passageiro->getCpf() != $this->passagem->getPassageiro()->getCpf()) {
            throw new ValueError("A passagem deste trecho não pertence ao passageiro");
        }
        $this->voo->desocuparAssento($passageiro);
    }
}
