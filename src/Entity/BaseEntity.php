<?php

namespace App\Entity;

interface BaseEntity
{
    public function shouldBePersisted(): bool;
}
