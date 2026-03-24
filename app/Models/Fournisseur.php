<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_fournisseur',
        'raison_sociale',
        'forme_juridique',
        'numero_registre',
        'adresse',
        'ville',
        'pays',
        'telephone',
        'email',
        'site_web',
        'contact_nom',
        'contact_prenom',
        'rib',
        'iban',
        'banque',
        'delai_paiement',
        'devise',
        'secteur_activite',
        'famille_produits',
        'statut',
        'is_deleted',
        'created_by',
    ];

    protected $casts = [
        'is_deleted'    => 'boolean',
        'delai_paiement'=> 'integer',
    ];

    // Relations
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bonsCommande()
    {
        return $this->hasMany(BonCommande::class);
    }

    // Scopes
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif')->where('is_deleted', false);
    }

    public function scopeNonArchive($query)
    {
        return $query->where('is_deleted', false);
    }

    // Générer code automatique
    public static function genererCode()
    {
        $dernier = self::orderBy('id', 'desc')->first();
        $numero  = $dernier ? $dernier->id + 1 : 1;
        return 'F-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}