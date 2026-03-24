<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemandeAchat extends Model
{
    use HasFactory;

    protected $table = 'demandes_achats';

    protected $fillable = [
        'numero',
        'objet',
        'description',
        'quantite',
        'unite_mesure',
        'budget_estimatif',
        'categorie',
        'centre_cout',
        'date_souhaitee',
        'statut',
        'motif_rejet',
        'demandeur_id',
        'validateur_id',
        'date_validation',
    ];

    protected $casts = [
        'date_souhaitee'  => 'date',
        'date_validation' => 'datetime',
        'quantite'        => 'decimal:2',
        'budget_estimatif'=> 'decimal:2',
    ];

    // Relations
    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'validateur_id');
    }

    public function bonsCommande()
    {
        return $this->hasMany(BonCommande::class);
    }

    // Générer numéro automatique
    public static function genererNumero()
    {
        $annee  = date('Y');
        $count  = self::whereYear('created_at', $annee)->count() + 1;
        return 'DA-' . $annee . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    // Scopes
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'soumise');
    }
}