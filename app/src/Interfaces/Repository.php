<?php
namespace App\Interfaces;

interface Repository
{
    public function score(): array | bool;
}