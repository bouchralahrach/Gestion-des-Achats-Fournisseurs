@extends('layouts.app')
@section('title', 'Bons de Commande')
@section('page-title', 'Bons de Commande')
@section('breadcrumb') Bons de Commande @endsection

@section('content')
<div class="card">

    {{-- HEADER --}}
    <div class="card-header">
        <div>
            <div class="card-title">Liste des Bons de Commande</div>
            <div class="card-subtitle">{{ $commandes->total() }} bon(s) de commande</div>
        </div>
        @can('bc.creer')
        <a href="{{ route('commandes.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouveau Bon de Commande
        </a>
        @endcan
    </div>

    {{-- FILTRES --}}
    <div class="filters-bar">
        <form method="GET" action="{{ route('commandes.index') }}" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;align-items:center">
            <div class="filter-wrap">
                <span class="filter-search-icon">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" class="filter-input" placeholder="Rechercher par numéro..." value="{{ request('search') }}">
            </div>
            <select name="statut" class="filter-select" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente"   {{ request('statut')=='en_attente'  ?'selected':'' }}>En attente</option>
                <option value="envoyee"      {{ request('statut')=='envoyee'     ?'selected':'' }}>Envoyée</option>
                <option value="confirmee"    {{ request('statut')=='confirmee'   ?'selected':'' }}>Confirmée</option>
                <option value="en_livraison" {{ request('statut')=='en_livraison'?'selected':'' }}>En livraison</option>
                <option value="soldee"       {{ request('statut')=='soldee'      ?'selected':'' }}>Soldée</option>
                <option value="annulee"      {{ request('statut')=='annulee'     ?'selected':'' }}>Annulée</option>
            </select>
            <select name="fournisseur_id" class="filter-select" onchange="this.form.submit()">
                <option value="">Tous les fournisseurs</option>
                @foreach($fournisseurs as $fournisseur)
                <option value="{{ $fournisseur->id }}" {{ request('fournisseur_id')==$fournisseur->id?'selected':'' }}>
                    {{ $fournisseur->raison_sociale }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('commandes.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </form>
    </div>

    {{-- TABLEAU --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Fournisseur</th>
                    <th>Date</th>
                    <th>Montant HT</th>
                    <th>TVA</th>
                    <th>Montant TTC</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr>
                    <td>
                        <strong style="color:var(--bleu)">{{ $commande->numero }}</strong>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($commande->fournisseur->raison_sociale ?? 'F',0,2)) }}
                            </div>
                            <span>{{ $commande->fournisseur->raison_sociale ?? '—' }}</span>
                        </div>
                    </td>
                    <td style="color:var(--gris);font-size:12px">{{ $commande->created_at->format('d/m/Y') }}</td>
                    <td>{{ number_format($commande->montant_ht,2,',',' ') }} MAD</td>
                    <td style="color:var(--gris)">{{ $commande->tva }}%</td>
                    <td><strong style="color:var(--vert)">{{ number_format($commande->montant_ttc,2,',',' ') }} MAD</strong></td>
                    <td><span class="badge badge-{{ $commande->statut }}">{{ ucfirst(str_replace('_',' ',$commande->statut)) }}</span></td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('commandes.show', $commande) }}" class="action-btn action-view">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @can('bc.creer')
                            @if($commande->statut === 'en_attente')
                            <a href="{{ route('commandes.edit', $commande) }}" class="action-btn action-edit">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endif
                            @endcan
                            <a href="{{ route('commandes.exportPdf', $commande) }}" class="action-btn action-view" target="_blank" title="PDF">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                        </div>
                        <h4>Aucun bon de commande</h4>
                        <p>Commencez par créer vos premiers bons de commande</p>
                        @can('bc.creer')
                        <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Créer un bon de commande
                        </a>
                        @endcan
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($commandes->hasPages())
    <div class="pagination">
        <div class="pagination-info">
            Affichage de {{ $commandes->firstItem() }} à {{ $commandes->lastItem() }} sur {{ $commandes->total() }} résultats
        </div>
        <div>{{ $commandes->appends(request()->query())->links() }}</div>
    </div>
    @endif
</div>
@endsection