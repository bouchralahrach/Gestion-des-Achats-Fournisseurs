<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\DemandeAchat;
use App\Models\BonCommande;
use App\Models\BonReception;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index()
    {
        $stats = [
            'total_fournisseurs'  => Fournisseur::where('statut','actif')->count(),
            'total_commandes'     => BonCommande::count(),
            'montant_total'       => BonCommande::whereNotIn('statut',['annulee'])->sum('montant_ttc'),
            'da_approuvees'       => DemandeAchat::where('statut','approuvee')->count(),
            'da_rejetees'         => DemandeAchat::where('statut','rejetee')->count(),
            'taux_conformite'     => $this->calculerTauxConformite(),
        ];

        // Commandes par mois (12 derniers mois) - Fixed for PostgreSQL
        $commandesParMois = BonCommande::selectRaw('EXTRACT(MONTH FROM created_at) as mois, EXTRACT(YEAR FROM created_at) as annee, COUNT(*) as total, SUM(montant_ttc) as montant')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)')
            ->orderByRaw('EXTRACT(MONTH FROM created_at) ASC')
            ->get();

        // Top 5 fournisseurs
        $topFournisseurs = Fournisseur::withCount('bonsCommande')
            ->orderBy('bons_commande_count', 'desc')
            ->take(5)->get();

        // DA par statut
        $daParStatut = DemandeAchat::selectRaw('statut, COUNT(*) as total')
            ->groupBy('statut')->get();

        return view('statistiques.index', compact('stats', 'commandesParMois', 'topFournisseurs', 'daParStatut'));
    }

    private function calculerTauxConformite()
    {
        $total    = BonReception::count();
        $conformes = BonReception::where('etat', 'conforme')->count();
        return $total > 0 ? round(($conformes / $total) * 100) : 0;
    }

    public function exportPdf()
    {
        $pdf = \PDF::loadView('statistiques.pdf');
        return $pdf->download('statistiques.pdf');
    }
}