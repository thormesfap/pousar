<?php

namespace App\Entities;

class Voo
{
    private int $numero;
    private string $codOrigem;
    private string $codDestino;
    private \DateTimeImmutable $dataHoraSaida;
    private \DateTimeImmutable $dataHoraChegada;
    private Aeronave $aeronave;
    private array $assentos;

    public function __construct(int $numero, string $codOrigem, string $codDestino, Aeronave $aeronave)
    {
        $this->numero = $numero;
        $this->codOrigem = $codOrigem;
        $this->codDestino = $codDestino;
        $this->aeronave = $aeronave;
        $this->assentos = $aeronave->gerarAssentos();
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setDataHoraSaida(\DateTimeImmutable $date)
    {
        $this->dataHoraSaida = $date;
        return $this;
    }
    public function setDataHoraChegada(\DateTimeImmutable $date)
    {
        $this->dataHoraChegada = $date;
        return $this;
    }
    public function getDataHoraSaida(): \DateTimeImmutable
    {
        return $this->dataHoraSaida;
    }
    public function getDataHoraChegada(): \DateTimeImmutable
    {
        return $this->dataHoraChegada;
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

    public function getAssentosDisponiveis(): array
    {
        return array_filter($this->assentos, fn (Assento $assento) => !$assento->estaOcupado());
    }

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
            throw new \ValueError("Assento já está ocupado");
        }
        $this->assentos[$index]->ocupar();
        $this->assentos[$index]->setPassageiro($passageiro);
    }

    public function desocuparAssento(string $codigo, Passageiro $passageiro): void
    {
        $index = $this->getIndexAssento($codigo);
        $assento = $this->assentos[$index];
        if ($assento->getPassageiro()->getCpf() == $passageiro->getCpf()) {
            $this->assentos[$index]->desocupar();
        }
        throw new \ValueError("Assento não pertence ao passageiro!");
    }

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
            throw new \ValueError("Não foi encontrado assento com o código informado");
        }
        return $index;
    }
}
