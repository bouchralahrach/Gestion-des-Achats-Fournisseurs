<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BonReception extends Model
{
    use HasFactory;

    protected $table = 'bons_reception';

    protected $fillable = [
        'numero',
        'bon_commande_id',
        'date_reception',
        'numero_livraison_fournisseur',
        'etat',
        'observations',
        'receptionnaire_id',
    ];

    protected $casts = [
        'date_reception' => 'date',
    ];

    // Relations
    public function bonCommande()
    {
        return $this->belongsTo(BonCommande::class);
    }

    public function receptionnaire()
    {
        return $this->belongsTo(User::class, 'receptionnaire_id');
    }

    // Générer numéro
    public static function genererNumero()
    {
        $annee = date('Y');
        $count = self::whereYear('created_at', $annee)->count() + 1;
        return 'BR-' . $annee . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}