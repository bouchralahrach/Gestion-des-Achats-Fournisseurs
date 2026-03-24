<?php

namespace App\Http\Controllers;

use App\Models\DemandeAchat;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DemandeAchatController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeAchat::with('demandeur', 'validateur');

        // Un demandeur voit seulement ses demandes
        if (auth()->user()->hasRole('demandeur')) {
            $query->where('demandeur_id', auth()->id());
        }

        if ($request->search) {
            $query->where('numero', 'like', '%'.$request->search.'%')
                  ->orWhere('objet', 'like', '%'.$request->search.'%');
        }

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        $demandes = $query->latest()->paginate(15);
        return view('demandes.index', compact('demandes'));
    }

    public function create()
    {
        return view('demandes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'objet'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'quantite'         => 'required|numeric|min:0.01',
            'unite_mesure'     => 'required|string|max:50',
            'budget_estimatif' => 'nullable|numeric|min:0',
            'date_souhaitee'   => 'nullable|date|after:today',
        ]);

        $data = $request->all();
        $data['numero']       = DemandeAchat::genererNumero();
        $data['demandeur_id'] = auth()->id();
        $data['statut']       = 'brouillon';

        $demande = DemandeAchat::create($data);
        AuditLog::log('created', $demande, null, $demande->toArray());

        return redirect()->route('demandes.show', $demande)
                         ->with('success', 'Demande créée avec succès !');
    }

    public function show(DemandeAchat $demande)
    {
        $demande->load('demandeur', 'validateur', 'bonsCommande.fournisseur');
        return view('demandes.show', compact('demande'));
    }

    public function edit(DemandeAchat $demande)
    {
        abort_if($demande->statut !== 'brouillon', 403, 'Cette demande ne peut plus être modifiée.');
        return view('demandes.edit', compact('demande'));
    }

    public function update(Request $request, DemandeAchat $demande)
    {
        abort_if($demande->statut !== 'brouillon', 403);

        $request->validate([
            'objet'        => 'required|string|max:255',
            'quantite'     => 'required|numeric|min:0.01',
            'unite_mesure' => 'required|string|max:50',
        ]);

        $old = $demande->toArray();
        $demande->update($request->all());
        AuditLog::log('updated', $demande, $old, $demande->toArray());

        return redirect()->route('demandes.show', $demande)
                         ->with('success', 'Demande mise à jour !');
    }

    public function soumettre(DemandeAchat $demande)
    {
        abort_if($demande->statut !== 'brouillon', 403);
        $demande->update(['statut' => 'soumise']);
        AuditLog::log('soumise', $demande);

        return back()->with('success', 'Demande soumise pour validation !');
    }

    public function approuver(Request $request, DemandeAchat $demande)
    {
        abort_if($demande->statut !== 'soumise', 403);

        $demande->update([
            'statut'          => 'approuvee',
            'validateur_id'   => auth()->id(),
            'date_validation' => now(),
        ]);
        AuditLog::log('approuvee', $demande);

        return back()->with('success', 'Demande approuvée avec succès !');
    }

    public function rejeter(Request $request, DemandeAchat $demande)
    {
        $request->validate(['motif_rejet' => 'required|string|min:10']);
        abort_if($demande->statut !== 'soumise', 403);

        $demande->update([
            'statut'          => 'rejetee',
            'motif_rejet'     => $request->motif_rejet,
            'validateur_id'   => auth()->id(),
            'date_validation' => now(),
        ]);
        AuditLog::log('rejetee', $demande);

        return back()->with('success', 'Demande rejetée.');
    }

    public function annuler(DemandeAchat $demande)
    {
        abort_if(!in_array($demande->statut, ['brouillon','soumise']), 403);
        $demande->update(['statut' => 'annulee']);
        AuditLog::log('annulee', $demande);

        return back()->with('success', 'Demande annulée.');
    }

    public function destroy(DemandeAchat $demande)
    {
        abort_if($demande->statut !== 'brouillon', 403);
        AuditLog::log('deleted', $demande, $demande->toArray(), null);
        $demande->delete();

        return redirect()->route('demandes.index')
                         ->with('success', 'Demande supprimée.');
    }
}