<?php

namespace App\Entities;

abstract class Pessoa extends Entity
{
    protected string $nome;
    protected string $cpf;
    protected string $telefone;

    public function getNome(): string
    {
        return $this->nome;
    }
    public function getCpf(): string
    {
        return $this->cpf;
    }
    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function setNome(string $nome):self{
        $this->nome = $nome;
        return $this;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;
        return $this;
    }
}
