<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KorisnikPodatak extends Model
{
    protected $table = 'korisnikpodatak';
    use HasFactory;

    protected $fillable = [
        'Odgovor',
        'IdPrijave'
    ];

    public function listaPrijava()
    {
        return $this->belongsTo(ListaPrijava::class);
    }
}
