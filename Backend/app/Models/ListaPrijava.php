<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaPrijava extends Model
{
    protected $table = 'listaPrijava';
    use HasFactory, SoftDeletes;

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
