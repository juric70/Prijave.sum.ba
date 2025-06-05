<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KorisnikPodatak extends Model
{
    protected $table = 'korisnikPodatak';
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'Odgovor',
        'IdPrijave'
    ];

    public function listaPrijava()
    {
        return $this->belongsTo(ListaPrijava::class);
    }
}
