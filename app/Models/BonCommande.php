<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonCommande extends Model
{
    use HasFactory;

    protected $table = 'bons_commande';

    protected $fillable = [
        'numero',
        'fournisseur_id',
        'demande_achat_id',
        'montant_ht',
        'tva',
        'montant_ttc',
        'conditions_livraison',
        'date_livraison_prevue',
        'lieu_livraison',
        'mode_paiement',
        'statut',
        'created_by',
        'date_envoi',
    ];

    protected $casts = [
        'montant_ht'           => 'decimal:2',
        'tva'                  => 'decimal:2',
        'montant_ttc'          => 'decimal:2',
        'date_livraison_prevue'=> 'date',
        'date_envoi'           => 'datetime',
    ];

    // Relations
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function demandeAchat()
    {
        return $this->belongsTo(DemandeAchat::class);
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class);
    }

    public function bonsReception()
    {
        return $this->hasMany(BonReception::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Générer numéro automatique
    public static function genererNumero()
    {
        $annee = date('Y');
        $count = self::whereYear('created_at', $annee)->count() + 1;
        return 'BC-' . $annee . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }

    // Calculer montant TTC
    public function calculerMontants()
    {
        $ht  = $this->lignes->sum('montant_total');
        $ttc = $ht * (1 + $this->tva / 100);
        $this->update(['montant_ht' => $ht, 'montant_ttc' => $ttc]);
    }
}