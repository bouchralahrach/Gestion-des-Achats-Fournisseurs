@extends('layouts.app')
@section('title', 'Demandes d\'Achat')
@section('page-title', 'Demandes d\'Achat')
@section('breadcrumb') Demandes d\'Achat @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Liste des Demandes d'Achat</div>
            <div class="card-subtitle">{{ $demandes->total() }} demandes trouvées</div>
        </div>
        @can('da.creer')
        <a href="{{ route('demandes.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle Demande
        </a>
        @endcan
    </div>

    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap">
            <div class="filter-wrap">
                <span class="filter-search-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                <input type="text" name="search" class="filter-input" placeholder="Numéro / Objet..." value="{{ request('search') }}">
            </div>
            <select name="statut" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="brouillon" {{ request('statut')=='brouillon'?'selected':'' }}>Brouillon</option>
                <option value="soumise" {{ request('statut')=='soumise'?'selected':'' }}>Soumise</option>
                <option value="approuvee" {{ request('statut')=='approuvee'?'selected':'' }}>Approuvée</option>
                <option value="rejetee" {{ request('statut')=='rejetee'?'selected':'' }}>Rejetée</option>
                <option value="annulee" {{ request('statut')=='annulee'?'selected':'' }}>Annulée</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('demandes.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Objet</th>
                    <th>Demandeur</th>
                    <th>Quantité</th>
                    <th>Budget</th>
                    <th>Date souhaitée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $demande)
                <tr>
                    <td><strong style="color:var(--bleu-clair)">{{ $demande->numero }}</strong></td>
                    <td>{{ Str::limit($demande->objet, 40) }}</td>
                    <td>{{ $demande->demandeur->name ?? '—' }}</td>
                    <td>{{ number_format($demande->quantite, 2) }} {{ $demande->unite_mesure }}</td>
                    <td>{{ $demande->budget_estimatif ? number_format($demande->budget_estimatif, 2, ',', ' ') . ' MAD' : '—' }}</td>
                    <td>{{ $demande->date_souhaitee?->format('d/m/Y') ?? '—' }}</td>
                    <td><span class="badge badge-{{ $demande->statut }}">{{ ucfirst(str_replace('_', ' ', $demande->statut)) }}</span></td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('demandes.show', $demande) }}" class="action-btn action-view" title="Voir">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @if($demande->statut === 'brouillon' && auth()->id() === $demande->demandeur_id)
                            <a href="{{ route('demandes.edit', $demande) }}" class="action-btn action-edit" title="Modifier">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="empty-icon"><svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/></svg></div>
                        <h4>Aucune demande d'achat</h4>
                        <p>Créez votre première demande d'achat</p>
                        @can('da.creer')
                        <a href="{{ route('demandes.create') }}" class="btn btn-primary">Nouvelle Demande</a>
                        @endcan
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <div class="pagination-info">{{ $demandes->firstItem() }} - {{ $demandes->lastItem() }} sur {{ $demandes->total() }}</div>
        <div>{{ $demandes->appends(request()->query())->links() }}</div>
    </div>
</div>
@endsection

