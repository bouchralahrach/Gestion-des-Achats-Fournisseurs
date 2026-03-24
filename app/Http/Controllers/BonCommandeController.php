<?php

namespace App\Http\Controllers;

use App\Models\BonCommande;
use App\Models\LigneCommande;
use App\Models\Fournisseur;
use App\Models\DemandeAchat;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BonCommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = BonCommande::with('fournisseur', 'createdBy');

        if ($request->search) {
            $query->where('numero', 'like', '%'.$request->search.'%');
        }
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        if ($request->fournisseur_id) {
            $query->where('fournisseur_id', $request->fournisseur_id);
        }

        $commandes    = $query->latest()->paginate(15);
        $fournisseurs = Fournisseur::actif()->get();
        return view('commandes.index', compact('commandes', 'fournisseurs'));
    }

    public function create(Request $request)
    {
        $fournisseurs = Fournisseur::actif()->get();
        $demandes     = DemandeAchat::where('statut', 'approuvee')->get();
        $demande      = $request->demande_id
                        ? DemandeAchat::find($request->demande_id)
                        : null;
        return view('commandes.create', compact('fournisseurs', 'demandes', 'demande'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id'       => 'required|exists:fournisseurs,id',
            'tva'                  => 'required|numeric|min:0|max:100',
            'date_livraison_prevue'=> 'nullable|date|after:today',
            'lignes'               => 'required|array|min:1',
            'lignes.*.designation' => 'required|string',
            'lignes.*.quantite'    => 'required|numeric|min:0.01',
            'lignes.*.prix_unitaire'=> 'required|numeric|min:0',
        ]);

        $bc = BonCommande::create([
            'numero'               => BonCommande::genererNumero(),
            'fournisseur_id'       => $request->fournisseur_id,
            'demande_achat_id'     => $request->demande_achat_id,
            'tva'                  => $request->tva,
            'conditions_livraison' => $request->conditions_livraison,
            'date_livraison_prevue'=> $request->date_livraison_prevue,
            'lieu_livraison'       => $request->lieu_livraison,
            'mode_paiement'        => $request->mode_paiement,
            'statut'               => 'en_attente',
            'created_by'           => auth()->id(),
        ]);

        foreach ($request->lignes as $ligne) {
            $base   = $ligne['quantite'] * $ligne['prix_unitaire'];
            $remise = $base * (($ligne['remise'] ?? 0) / 100);
            LigneCommande::create([
                'bon_commande_id' => $bc->id,
                'designation'     => $ligne['designation'],
                'quantite'        => $ligne['quantite'],
                'unite'           => $ligne['unite'] ?? 'unité',
                'prix_unitaire'   => $ligne['prix_unitaire'],
                'remise'          => $ligne['remise'] ?? 0,
                'tva'             => $request->tva,
                'montant_total'   => $base - $remise,
            ]);
        }

        $bc->calculerMontants();
        AuditLog::log('created', $bc, null, $bc->toArray());

        return redirect()->route('commandes.show', $bc)
                         ->with('success', 'Bon de commande créé avec succès !');
    }

    public function show(BonCommande $commande)
    {
        $commande->load('fournisseur', 'lignes', 'demandeAchat', 'bonsReception', 'createdBy');
        return view('commandes.show', compact('commande'));
    }

    public function edit(BonCommande $commande)
    {
        abort_if(!in_array($commande->statut, ['en_attente']), 403);
        $fournisseurs = Fournisseur::actif()->get();
        return view('commandes.edit', compact('commande', 'fournisseurs'));
    }

    public function update(Request $request, BonCommande $commande)
    {
        abort_if($commande->statut !== 'en_attente', 403);
        $old = $commande->toArray();
        $commande->update($request->except(['lignes', '_token', '_method']));

        if ($request->lignes) {
            $commande->lignes()->delete();
            foreach ($request->lignes as $ligne) {
                $base = $ligne['quantite'] * $ligne['prix_unitaire'];
                $remise = $base * (($ligne['remise'] ?? 0) / 100);
                LigneCommande::create([
                    'bon_commande_id' => $commande->id,
                    'designation'     => $ligne['designation'],
                    'quantite'        => $ligne['quantite'],
                    'unite'           => $ligne['unite'] ?? 'unité',
                    'prix_unitaire'   => $ligne['prix_unitaire'],
                    'remise'          => $ligne['remise'] ?? 0,
                    'tva'             => $request->tva,
                    'montant_total'   => $base - $remise,
                ]);
            }
            $commande->calculerMontants();
        }

        AuditLog::log('updated', $commande, $old, $commande->toArray());
        return redirect()->route('commandes.show', $commande)
                         ->with('success', 'Bon de commande mis à jour !');
    }

    public function valider(BonCommande $commande)
    {
        abort_if($commande->statut !== 'en_attente', 403);
        $commande->update(['statut' => 'envoyee']);
        AuditLog::log('validee', $commande);
        return back()->with('success', 'Commande validée !');
    }

    public function envoyer(BonCommande $commande)
    {
        abort_if($commande->statut !== 'envoyee', 403);
        $commande->update(['statut' => 'confirmee', 'date_envoi' => now()]);
        AuditLog::log('envoyee', $commande);
        return back()->with('success', 'Commande envoyée au fournisseur !');
    }

    public function annuler(Request $request, BonCommande $commande)
    {
        abort_if(in_array($commande->statut, ['soldee', 'annulee']), 403);
        $commande->update(['statut' => 'annulee']);
        AuditLog::log('annulee', $commande);
        return back()->with('success', 'Commande annulée.');
    }

    public function destroy(BonCommande $commande)
    {
        abort_if($commande->statut !== 'en_attente', 403);
        AuditLog::log('deleted', $commande, $commande->toArray(), null);
        $commande->lignes()->delete();
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée.');
    }

    public function exportPdf(BonCommande $commande)
    {
        $commande->load('fournisseur', 'lignes', 'createdBy');
        $pdf = \PDF::loadView('commandes.pdf', compact('commande'));
        return $pdf->stream('BC-'.$commande->numero.'.pdf');
    }
}