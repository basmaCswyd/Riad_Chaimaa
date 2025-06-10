<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'reservation_date',
        'reservation_time',
        'guests',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
    ];

    // RELATION : Une réservation appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELATION : Une réservation est assignée à une table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}