<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KorisnikPodatakFactory extends Factory
{
    public function definition(): array
    {
        return [
            'IdPrijave' => 1,
            'Odgovor' => 'Prva Opcija',
        ];
    }
}
