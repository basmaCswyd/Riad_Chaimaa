<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- CETTE LIGNE EST LA CORRECTION !

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <--- 'HasApiTokens' ici fonctionne maintenant

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_admin',
        'prenom',
        'nom',
        'email',
        'num_telephone',
        'annee_naissance',
        'cin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // RELATION : Un utilisateur peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // RELATION : Un utilisateur peut initier plusieurs tickets de message
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}