<?php

namespace App\Models;

// 1. Add this import
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // 2. Add HasFactory here
    use Notifiable, HasRoles, HasFactory;

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'telephone',
        'departement',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // Relations
    public function demandesAchats()
    {
        return $this->hasMany(DemandeAchat::class, 'demandeur_id');
    }

    public function validations()
    {
        return $this->hasMany(DemandeAchat::class, 'validateur_id');
    }

    public function bonsCommande()
    {
        return $this->hasMany(BonCommande::class, 'created_by');
    }

    public function receptions()
    {
        return $this->hasMany(BonReception::class, 'receptionnaire_id');
    }

    // Nom complet
    public function getNomCompletAttribute()
    {
        return $this->name . ' ' . $this->prenom;
    }
}