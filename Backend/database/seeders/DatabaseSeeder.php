<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'vrstaKorisnika' => 1,
        ]);

        \App\Models\User::factory(6)->create([]);

        \App\Models\Radionica::factory()->create([
            'NazivRadionice' => 'Ovu Radionicu Testirajte',
            'OpisRadionice' => 'Ovo je opis neke radionice koju bi trebali testirati',
            'DatumPocetka' => '2026-11-11 00:00:00',
            'DatumZavrsetka' => '2026-12-11 00:00:00',
            'PrijaveDo' => '2026-10-11 00:00:00',
        ]);

        \App\Models\Radionica::factory(12)->create([]);

        \App\Models\PitanjaRadionice::factory(7)->create([]);

        \App\Models\ListaPrijava::factory()->create(['IdKreatora' => 2]);
        \App\Models\ListaPrijava::factory()->create(['IdKreatora' => 3]);
        \App\Models\ListaPrijava::factory()->create(['IdKreatora' => 4]);
        \App\Models\KorisnikPodatak::factory(7)->create(['IdPrijave' => 1]);
        \App\Models\KorisnikPodatak::factory(7)->create(['IdPrijave' => 2]);
        \App\Models\KorisnikPodatak::factory(7)->create(['IdPrijave' => 3]);
    }
}
