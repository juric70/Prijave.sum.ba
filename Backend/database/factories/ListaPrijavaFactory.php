<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListaPrijavaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'IdKreatora' => 1,
            'IdRadionice' => 1,
        ];
    }
}
