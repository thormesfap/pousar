<?php

namespace App\Entities;

class Trecho{
    private Assento $assento;
    private Voo $voo;

    public function __construct(Voo $voo)
    {
        $this->voo = $voo;
    }

    public function marcarAssento(string $codigo, Passageiro $passageiro){
        $this->voo->ocuparAssento($codigo, $passageiro);
    }
}