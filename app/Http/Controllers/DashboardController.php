<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournisseur;
use App\Models\DemandeAchat;
use App\Models\BonCommande;
use App\Models\BonReception;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'stats' => [
                'fournisseurs'  => Fournisseur::where('statut', 'actif')->count(),
                'da_en_attente' => DemandeAchat::where('statut', 'soumise')->count(),
                'da_total'      => DemandeAchat::count(),
                'bc_mois'       => BonCommande::whereMonth('created_at', now()->month)->count(),
                'montant_mois'  => BonCommande::whereMonth('created_at', now()->month)->sum('montant_ttc'),
                'br_mois'       => BonReception::whereMonth('created_at', now()->month)->count(),
                'conformite'    => 95,
            ],
            'dernieres_demandes'  => DemandeAchat::with('demandeur')->latest()->take(5)->get(),
            'dernieres_commandes' => BonCommande::with('fournisseur')->latest()->take(5)->get(),
            'top_fournisseurs'    => Fournisseur::withCount('bonsCommande')->latest()->take(5)->get(),
        ]);
    }
}