<?php

namespace App\Entities;

class Passageiro extends Pessoa{
    private string $telefoneContato;
    private string $email;

    public function __construct(string $nome, string $cpf, string $telefone)
    {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
    }

    public function setTelefoneContato(string $telefone):self{
        $this->telefoneContato = $telefone;
        return $this;
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

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}