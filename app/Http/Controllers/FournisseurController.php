<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $query = Fournisseur::nonArchive()->with('createdBy');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('raison_sociale', 'like', '%'.$request->search.'%')
                  ->orWhere('code_fournisseur', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('ville', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->statut) {
            $query->where('statut', $request->statut);
        }

        if ($request->secteur) {
            $query->where('secteur_activite', 'like', '%'.$request->secteur.'%');
        }

        $fournisseurs = $query->latest()->paginate(15);
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'raison_sociale'  => 'required|string|max:255',
            'email'           => 'nullable|email|unique:fournisseurs,email',
            'telephone'       => 'nullable|string|max:20',
            'statut'          => 'required|in:actif,inactif,suspendu,en_qualification',
            'delai_paiement'  => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['code_fournisseur'] = Fournisseur::genererCode();
        $data['created_by']       = auth()->id();

        $fournisseur = Fournisseur::create($data);
        AuditLog::log('created', $fournisseur, null, $fournisseur->toArray());

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur créé avec succès !');
    }

    public function show(Fournisseur $fournisseur)
    {
        $fournisseur->load(['bonsCommande.lignes', 'createdBy']);
        return view('fournisseurs.show', compact('fournisseur'));
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email'          => 'nullable|email|unique:fournisseurs,email,'.$fournisseur->id,
            'statut'         => 'required|in:actif,inactif,suspendu,en_qualification',
            'delai_paiement' => 'nullable|integer|min:0',
        ]);

        $oldValues = $fournisseur->toArray();
        $fournisseur->update($request->all());
        AuditLog::log('updated', $fournisseur, $oldValues, $fournisseur->toArray());

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur mis à jour avec succès !');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        // Vérifier commandes actives
        $commandesActives = $fournisseur->bonsCommande()
            ->whereNotIn('statut', ['soldee', 'annulee'])->count();

        if ($commandesActives > 0) {
            return back()->with('error', 'Impossible de supprimer : ce fournisseur a des commandes actives en cours.');
        }

        AuditLog::log('deleted', $fournisseur, $fournisseur->toArray(), null);
        $fournisseur->update(['is_deleted' => true]);

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur archivé avec succès.');
    }

    public function restore(Fournisseur $fournisseur)
    {
        $fournisseur->update(['is_deleted' => false]);
        AuditLog::log('restored', $fournisseur, null, $fournisseur->toArray());

        return back()->with('success', 'Fournisseur restauré avec succès.');
    }

    public function exportPdf()
    {
        $fournisseurs = Fournisseur::nonArchive()->get();
        $pdf = \PDF::loadView('fournisseurs.pdf', compact('fournisseurs'));
        return $pdf->download('fournisseurs.pdf');
    }

    public function exportExcel()
    {
        return \Excel::download(new \App\Exports\FournisseursExport, 'fournisseurs.xlsx');
    }
}