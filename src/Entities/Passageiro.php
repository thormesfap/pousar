<?php

namespace App\Entities;

class Passageiro extends Pessoa{
    private string $telefoneContato;

    public function __construct(string $nome, string $cpf, string $telefone)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
    }

    public function setTelefoneContato(string $telefone){
        $this->telefoneContato = $telefone;
    }
    public function getTelefoneContato(): string{
        return $this->telefoneContato ?? "Não informado";
    }
    public function marcarAssento(string $codigo, Trecho $trecho){
        $trecho->marcarAssento($codigo, $this);
    }
    public function desmarcarAssento(Trecho $trecho){
        $trecho->desmarcarAssento($this);
    }
}