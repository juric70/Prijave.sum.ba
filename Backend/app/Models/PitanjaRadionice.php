<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PitanjaRadionice extends Model
{
    protected $table = 'pitanjaRadionice';
    use HasFactory, SoftDeletes;

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
