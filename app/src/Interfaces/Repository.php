<?php
namespace App\Interfaces;

interface Repository
{
    public function calculateScore(): array;
}