<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zone',
        'capacity',
        'description',
    ];

    // RELATION : Une table peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    // RELATION : Une table peut être réservée par plusieurs utilisateurs
    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations');
    }
}