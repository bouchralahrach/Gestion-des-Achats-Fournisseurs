@extends('layouts.app')
@section('title', 'Réceptions')
@section('page-title', 'Bons de Réception')
@section('breadcrumb') Réceptions @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Liste des Bons de Réception</div>
            <div class="card-subtitle">{{ $receptions->total() }} réceptions trouvées</div>
        </div>
        @can('br.creer')
        <a href="{{ route('receptions.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouveau BR
        </a>
        @endcan
    </div>

    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap">
            <div class="filter-wrap">
                <span class="filter-search-icon">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" class="filter-input" placeholder="Numéro BR..." value="{{ request('search') }}">
            </div>
            <select name="etat" class="filter-select">
                <option value="">Tous les états</option>
                <option value="conforme" {{ request('etat')=='conforme'?'selected':'' }}>Conforme</option>
                <option value="non_conforme" {{ request('etat')=='non_conforme'?'selected':'' }}>Non conforme</option>
                <option value="avec_reserves" {{ request('etat')=='avec_reserves'?'selected':'' }}>Avec réserves</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('receptions.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Numéro BR</th>
                    <th>Date</th>
                    <th>Bon de Commande</th>
                    <th>Fournisseur</th>
                    <th>État</th>
                    <th>Réceptionnaire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receptions as $br)
                <tr>
                    <td><strong style="color:var(--bleu-clair)">{{ $br->numero }}</strong></td>
                    <td>{{ $br->date_reception->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('commandes.show', $br->bonCommande) }}"
                           style="color:var(--bleu-clair);font-weight:600;text-decoration:none">
                            {{ $br->bonCommande->numero }}
                        </a>
                    </td>
                    <td>{{ Str::limit($br->bonCommande->fournisseur->raison_sociale, 25) }}</td>
                    <td>
                        <span class="badge badge-{{ $br->etat }}">
                            {{ ucfirst(str_replace('_',' ',$br->etat)) }}
                        </span>
                    </td>
                    <td>{{ $br->receptionnaire->name }} {{ $br->receptionnaire->prenom }}</td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('receptions.show', $br) }}" class="action-btn action-view" title="Voir">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><path d="M12 22V7"/></svg>
                        </div>
                        <h4>Aucune réception</h4>
                        <p>Enregistrez votre première réception de marchandises</p>
                        @can('br.creer')
                        <a href="{{ route('receptions.create') }}" class="btn btn-primary">Nouveau BR</a>
                        @endcan
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($receptions->hasPages())
    <div class="pagination">
        <div class="pagination-info">
            {{ $receptions->firstItem() }} - {{ $receptions->lastItem() }} sur {{ $receptions->total() }}
        </div>
        <div>{{ $receptions->links() }}</div>
    </div>
    @endif
</div>
@endsection