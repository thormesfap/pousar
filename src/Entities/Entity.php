<?php

namespace App\Entities;

abstract class Entity
{
    private ?int $id;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }
    public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
    }
}
