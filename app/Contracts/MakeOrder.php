<?php

namespace App\Contracts;

interface MakeOrder
{
    public function freeOrder();

    public function paidOrder();

    public function hasPrice(): bool;

    public function ownedByUser(): bool;
}
