<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class pitanjaRadioniceFactory extends Factory
{
    public function definition(): array
    {
        $var = rand(1,1000);
        if($var > 667){
            return [
                'NazivPitanja' => 'Ovo je neko pitanje gdje korisnik unosi tekst kao odgovor: ',
                'OpcijePitanja' => 'KratkiOdgovor',
                'VrstaPodatka' => 'KratkiOdgovor',
                'radionice' => 1,
            ];
        }
        else if($var > 334){
            return [
                'NazivPitanja' => 'Ovo je neko pitanje gdje korisnik unosi vise tocnih odgovora: ',
                'OpcijePitanja' => 'Prva opcija;Druga opcija;Treca opcija',
                'VrstaPodatka' => 'ViseTocnih',
                'radionice' => 1,
            ];
        }
        else{
            return [
                'NazivPitanja' => 'Ovo je neko pitanje gdje korisnik unosi jedan od tocnih odgovora: ',
                'OpcijePitanja' => 'Prva opcija;Druga opcija;Treca opcija',
                'VrstaPodatka' => 'JedanOd',
                'radionice' => 1,
            ];
        }
    }
}
