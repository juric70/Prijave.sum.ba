<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Radionica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'radionica';

    protected $fillable = [
        'NazivRadionice',
        'OpisRadionice',
        'UrlSlike',
        'VoditeljRadionice',
        'Tagovi',
        'DatumPocetka',
        'DatumZavrsetka',
        'PrijaveDo',
        'IdKreatora'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pitanjaRadionice()
    {
        return $this->hasMany(PitanjaRadionice::class);
    }

    public function listaPrijava()
    {
        return $this->hasMany(listaPrijava::class);
    }
}
