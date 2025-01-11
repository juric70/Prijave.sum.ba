<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class radionicaFactory extends Factory
{
    public function definition(): array
    {
        $var = rand(1,1000);
        if($var > 500){
            return [
                'NazivRadionice' => 'Test Radionica ' . (string)$var,
                'OpisRadionice' => 'Testni Opis Radionice ' . (string)$var,
                'UrlSlike' => 'Slika',
                'Tagovi' => 'Tagovi',
                'VoditeljRadionice' => 'Admin',
                'DatumPocetka' => '2026-11-11 00:00:00',
                'DatumZavrsetka' => '2026-12-11 00:00:00',
                'PrijaveDo' => '2026-10-11 00:00:00',
                'IdKreatora' => 1,
            ];
        }
        else{
            return [
                'NazivRadionice' => 'Test Radionica ' . (string)$var,
                'OpisRadionice' => 'Testni Opis Radionice ' . (string)$var,
                'UrlSlike' => 'Slika',
                'Tagovi' => 'Tagovi',
                'VoditeljRadionice' => 'Admin',
                'DatumPocetka' => '2023-11-11 00:00:00',
                'DatumZavrsetka' => '2023-12-11 00:00:00',
                'PrijaveDo' => '2023-10-11 00:00:00',
                'IdKreatora' => 1,
            ];
        }
    }
}
