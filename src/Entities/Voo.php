<?php

namespace App\Entities;

class Voo extends Entity
{
    private int $numero;
    private string $codOrigem;
    private string $codDestino;
    private string $horaSaida;
    private string $horaChegada;
    private Aeronave $aeronave;
    private CiaAerea $ciaAerea;
    private array $assentos;

    public function __construct(int $numero, string $codOrigem, string $codDestino, Aeronave $aeronave, CiaAerea $ciaAerea)
    {
        $this->numero = $numero;
        $this->codOrigem = $codOrigem;
        $this->codDestino = $codDestino;
        $this->aeronave = $aeronave;
        $this->ciaAerea = $ciaAerea;
        $this->assentos = $aeronave->gerarAssentos();
    }

    public function getNumero()
    {
        return $this->numero;
    }
    public function getCiaAerea(){
        return $this->ciaAerea;
    }

    public function getAeronave(){
        return $this->aeronave;
    }

    public function setHoraSaida(string $hora)
    {
        $this->horaSaida = $hora;
        return $this;
    }
    public function setHoraChegada(string $hora)
    {
        $this->horaChegada = $hora;
        return $this;
    }
    public function getHoraSaida(): ?string
    {
        return $this->horaSaida ?? '';
    }
    public function getHoraChegada(): ?string
    {
        return $this->horaChegada ?? '';
    }
    public function getCodigoOrigem()
    {
        return $this->codOrigem;
    }
    public function getCodigoDestino()
    {
        return $this->codDestino;
    }

    public function getAssentos(): array
    {
        return $this->assentos;
    }
    // filtra assentos que não estão ocupados
    public function getAssentosDisponiveis(): array
    {
        return array_filter($this->assentos, fn (Assento $assento) => !$assento->estaOcupado());
    }
    // filtra assentos que estão ocupados
    public function getAssentosOcupados(): array
    {
        return array_filter($this->assentos, fn (Assento $assento) => $assento->estaOcupado());
    }

    public function getQuantidadeAssentosDisponiveis(): int{
        return count($this->getAssentosDisponiveis());
    }

    public function getQuantidadeAssentosOcupados(): int{
        return count($this->getAssentosOcupados());
    }

    public function ocuparAssento(string $codigo, Passageiro $passageiro): void
    {
        $index = $this->getIndexAssento($codigo);
        if ($this->assentos[$index]->estaOcupado()) {
            // Lança erro caso o assento esteja ocupado
            throw new \ValueError("Assento já está ocupado");
        }
        $indexAssentoExistente = $this->getIndexAssentoPassageiro($passageiro);
        if($indexAssentoExistente > -1){
            $this->assentos[$indexAssentoExistente]->desocupar();
        }
        $this->assentos[$index]->ocupar($passageiro);
    }

    public function desocuparAssento(Passageiro $passageiro): void
    {
        $index = $this->getIndexAssentoPassageiro($passageiro);
        if($index == -1){
            //Passageiro ainda não marcou a passagem
            return;
        }
        $this->assentos[$index]->desocupar();
    }

    // Procurar o indice do assento a partir do passageiro
    private function getIndexAssentoPassageiro(Passageiro $passageiro){
        $index = -1;
        for ($i = 0; $i < count($this->assentos); $i++) {
            if ($this->assentos[$i]->getPassageiro()?->getCpf() == $passageiro->getCpf()) {
                $index = $i;
                $i = count($this->assentos);
            }
        }
        return $index;
    }

    // Procurar o indice do assento pelo código informado
    private function getIndexAssento(string $codigo): int
    {
        $index = -1;
        for ($i = 0; $i < count($this->assentos); $i++) {
            if ($this->assentos[$i]->getCodigo() == $codigo) {
                $index = $i;
                $i = count($this->assentos);
            }
        }
        if ($index < 0) {
            throw new \ValueError("Não foi encontrado assento com o código informado '$codigo'");
        }
        return $index;
    }

    // Imprime o mapa de assentos do vôo, com detalhamento dos assentos ocupados (vermelho) e disponíveis (verde)
    public function printMapa(){
        $count = 0;
        $assentos = $this->aeronave->getAssentosFila();
        echo "Mapa de Assentos do voo {$this->numero} operado por {$this->ciaAerea->getRazaoSocial()} em um avião {$this->aeronave->getSigla()} {$this->aeronave->getMarca()}";
        foreach($this->assentos as $assento){
            if($count % $assentos == 0){
                echo "\n";
            }
            if(($count % (int)($assentos / 2)) == 0 && ($count % ($assentos)) !== 0){
                echo "\t";
            }
            if($assento->estaOcupado()){
                echo "\033[01;31m{$assento->getCodigo()}\033[0m ";
            } else{
                echo "\033[01;32m{$assento->getCodigo()}\033[0m ";
            }
            $count++;
        }
    }
}
