@extends('layouts.app')
@section('title', $fournisseur->raison_sociale)
@section('page-title', $fournisseur->raison_sociale)
@section('breadcrumb') <a href="{{ route('fournisseurs.index') }}">Fournisseurs</a> <span>›</span> {{ $fournisseur->code_fournisseur }} @endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 2fr;gap:20px">

    <!-- Info carte -->
    <div>
        <div class="card" style="margin-bottom:20px">
            <div class="form-card-body" style="padding:24px;text-align:center">
                <div style="width:70px;height:70px;border-radius:18px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:'Outfit',sans-serif;font-size:24px;font-weight:800;color:white">
                    {{ strtoupper(substr($fournisseur->raison_sociale,0,2)) }}
                </div>
                <h3 style="font-family:'Outfit',sans-serif;font-size:18px;font-weight:700;margin-bottom:4px">{{ $fournisseur->raison_sociale }}</h3>
                <div style="font-size:12px;color:var(--gris);margin-bottom:12px">{{ $fournisseur->code_fournisseur }}</div>
                <span class="badge badge-{{ $fournisseur->statut }}">{{ ucfirst(str_replace('_',' ',$fournisseur->statut)) }}</span>
            </div>
            <div style="padding:0 24px 24px;display:flex;flex-direction:column;gap:12px">
                @can('fournisseurs.modifier')
                <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="btn btn-primary" style="justify-content:center">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modifier
                </a>
                @endcan
                <a href="{{ route('fournisseurs.index') }}" class="btn btn-outline" style="justify-content:center">Retour</a>
            </div>
        </div>

        <!-- Stats -->
        <div class="card">
            <div class="card-header"><div class="card-title">Statistiques</div></div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:16px">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:13px;color:var(--gris)">Total commandes</span>
                    <strong>{{ $fournisseur->bonsCommande->count() }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:13px;color:var(--gris)">Montant total</span>
                    <strong>{{ number_format($fournisseur->bonsCommande->sum('montant_ttc'),2,',',' ') }} MAD</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:13px;color:var(--gris)">Délai paiement</span>
                    <strong>{{ $fournisseur->delai_paiement }} jours</strong>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="font-size:13px;color:var(--gris)">Devise</span>
                    <strong>{{ $fournisseur->devise }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Détails -->
    <div style="display:flex;flex-direction:column;gap:20px">

        <!-- Coordonnées -->
        <div class="card">
            <div class="card-header"><div class="card-title">Coordonnées</div></div>
            <div style="padding:20px;display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Email</div>
                    <div style="font-size:14px">{{ $fournisseur->email ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Téléphone</div>
                    <div style="font-size:14px">{{ $fournisseur->telephone ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Adresse</div>
                    <div style="font-size:14px">{{ $fournisseur->adresse ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Ville / Pays</div>
                    <div style="font-size:14px">{{ $fournisseur->ville ?? '—' }} / {{ $fournisseur->pays }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Contact</div>
                    <div style="font-size:14px">{{ $fournisseur->contact_prenom }} {{ $fournisseur->contact_nom }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px">Site web</div>
                    <div style="font-size:14px">{{ $fournisseur->site_web ?? '—' }}</div>
                </div>
            </div>
        </div>

        <!-- Dernières commandes -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Historique des commandes</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Numéro</th><th>Date</th><th>Montant TTC</th><th>Statut</th></tr>
                    </thead>
                    <tbody>
                        @forelse($fournisseur->bonsCommande->take(10) as $bc)
                        <tr>
                            <td><strong style="color:var(--bleu-clair)">{{ $bc->numero }}</strong></td>
                            <td>{{ $bc->created_at->format('d/m/Y') }}</td>
                            <td><strong>{{ number_format($bc->montant_ttc,2,',',' ') }} MAD</strong></td>
                            <td><span class="badge badge-{{ $bc->statut }}">{{ ucfirst(str_replace('_',' ',$bc->statut)) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--gris);padding:30px">Aucune commande</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection