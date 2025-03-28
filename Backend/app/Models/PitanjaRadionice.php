<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitanjaRadionice extends Model
{
    protected $table = 'pitanjaRadionice';

    use HasFactory;

    protected $fillable = [
        'NazivPitanja',
        'OpcijePitanja',
        'VrstaPodatka',
        'radionice'
    ];

    public function radionica()
    {
        return $this->belongsTo(Radionica::class);
    }
}
