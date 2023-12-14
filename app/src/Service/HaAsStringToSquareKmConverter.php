<?php

namespace App\Service;

class HaAsStringToSquareKmConverter
{
    public function convert(?string $haAsString): float
    {
        //@TODO this is just a boilerplate to do not do such calculation in extractor
        return is_string($haAsString) ? (float) str_replace(',', '.', $haAsString) : 0;
    }
}