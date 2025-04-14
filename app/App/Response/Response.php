<?php

namespace App\Response;

abstract class Response
{
    abstract public function toArray(): array;

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}