<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'lignes_commande';

    protected $fillable = [
        'bon_commande_id',
        'designation',
        'quantite',
        'unite',
        'prix_unitaire',
        'remise',
        'tva',
        'montant_total',
    ];

    protected $casts = [
        'quantite'      => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'remise'        => 'decimal:2',
        'tva'           => 'decimal:2',
        'montant_total' => 'decimal:2',
    ];

    public function bonCommande()
    {
        return $this->belongsTo(BonCommande::class);
    }

    // Calcul automatique du montant
    public function calculerMontant()
    {
        $base   = $this->quantite * $this->prix_unitaire;
        $remise = $base * ($this->remise / 100);
        return $base - $remise;
    }
}