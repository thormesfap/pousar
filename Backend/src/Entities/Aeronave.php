<?php

namespace App\Entities;

class Aeronave{
    private string $sigla;
    private int $qteAssentos;
    private int $qteFileiras;
    private int $assentosPorFila;
    private int $assentosPrioritarios;
    private string $marca;

    public function __construct(string $sigla, string $marca, int $qteFileiras, int $assentosPorFila, int $assentosPrioritarios)
    {
        $this->sigla = $sigla;
        $this->marca = $marca;
        $this->qteFileiras = $qteFileiras;
        $this->qteAssentos = $qteFileiras * $assentosPorFila;
        $this->assentosPorFila = $assentosPorFila;
        $this->assentosPrioritarios = $assentosPrioritarios;
    }
    //Método para gerar assentos de acordo com a quantidade de fileiras e assentos por fila
    public function gerarAssentos(): array{
        $assentos = [];
        for($i = 1; $i <= $this->qteFileiras; $i++){
            for($j = 0; $j < $this->assentosPorFila; $j++){
                $letra = chr($j + 65);
                $assento = new Assento("{$i}{$letra}");
                $assentos[] = $assento;
            }
        }
        return $assentos;
    }

    public function getAssentosFila(){
        return $this->assentosPorFila;
    }
    public function getQuantidadeFilas(){
        return $this->qteFileiras;
    }
    public function getSigla(){
        return $this->sigla;
    }
    public function getMarca(){
        return $this->marca;
    }

}