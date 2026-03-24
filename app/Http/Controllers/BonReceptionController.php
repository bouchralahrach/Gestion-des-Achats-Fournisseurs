<?php

namespace App\Http\Controllers;

use App\Models\BonReception;
use App\Models\BonCommande;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BonReceptionController extends Controller
{
    public function index(Request $request)
    {
        $query = BonReception::with('bonCommande.fournisseur', 'receptionnaire');

        if ($request->search) {
            $query->where('numero', 'like', '%'.$request->search.'%');
        }
        if ($request->etat) {
            $query->where('etat', $request->etat);
        }

        $receptions = $query->latest()->paginate(15);
        $commandes  = BonCommande::whereIn('statut', ['confirmee', 'en_livraison'])
                                ->with('fournisseur')->get();
        
        return view('receptions.index', compact('receptions', 'commandes'));
    }

    public function create(Request $request)
    {
        $commandes = BonCommande::whereIn('statut', ['confirmee', 'en_livraison'])
                                ->with('fournisseur')->get();
        $commande  = $request->bon_commande_id
                    ? BonCommande::with('lignes','fournisseur')->find($request->bon_commande_id)
                    : null;
        return view('receptions.create', compact('commandes', 'commande'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bon_commande_id' => 'required|exists:bons_commande,id',
            'date_reception'  => 'required|date',
            'etat'            => 'required|in:conforme,non_conforme,avec_reserves',
            'observations'    => 'nullable|string',
        ]);

        $br = BonReception::create([
            'numero'                       => BonReception::genererNumero(),
            'bon_commande_id'              => $request->bon_commande_id,
            'date_reception'               => $request->date_reception,
            'numero_livraison_fournisseur' => $request->numero_livraison_fournisseur,
            'etat'                         => $request->etat,
            'observations'                 => $request->observations,
            'receptionnaire_id'            => auth()->id(),
        ]);

        // Mettre à jour statut BC
        $bc = BonCommande::find($request->bon_commande_id);
        $bc->update(['statut' => 'soldee']);

        AuditLog::log('created', $br, null, $br->toArray());

        return redirect()->route('receptions.show', $br)
                         ->with('success', 'Bon de réception créé avec succès !');
    }

    public function show(BonReception $reception)
    {
        $reception->load('bonCommande.fournisseur', 'bonCommande.lignes', 'receptionnaire');
        return view('receptions.show', compact('reception'));
    }

    public function edit(BonReception $reception)
    {
        $commandes = BonCommande::with('fournisseur')->get();
        return view('receptions.edit', compact('reception', 'commandes'));
    }

    public function update(Request $request, BonReception $reception)
    {
        $request->validate([
            'date_reception' => 'required|date',
            'etat'           => 'required|in:conforme,non_conforme,avec_reserves',
        ]);

        $old = $reception->toArray();
        $reception->update($request->all());
        AuditLog::log('updated', $reception, $old, $reception->toArray());

        return redirect()->route('receptions.show', $reception)
                         ->with('success', 'Bon de réception mis à jour !');
    }
}