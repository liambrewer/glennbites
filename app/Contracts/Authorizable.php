<?php

namespace App\Contracts;

interface Authorizable
{
    public function getId(): int;
    public function isEmployee(): bool;
}
