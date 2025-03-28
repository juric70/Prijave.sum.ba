<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaPrijava extends Model
{
    protected $table = 'listaprijava';
    use HasFactory;

    protected $fillable = [
        'IdKreatora',
        'IdRadionice'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function radionica()
    {
        return $this->belongsTo(Radionica::class);
    }

    public function korisnikPodatak()
    {
        return $this->hasMany(KorisnikPodatak::class);
    }
}
