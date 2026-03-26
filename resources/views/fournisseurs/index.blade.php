@extends('layouts.app')
@section('title', 'Fournisseurs')
@section('page-title', 'Fournisseurs')
@section('breadcrumb') Fournisseurs @endsection

@push('styles')
<style>
    /* CSS spécifique pour améliorer l'affichage sur mobile de la vue Index */
    @media (max-width: 768px) {
        /* On s'assure que les filtres prennent 100% de la largeur sur mobile */
        .filters-bar form {
            flex-direction: column;
            width: 100%;
        }
        .filter-wrap, .filter-select, .btn-sm {
            width: 100%; /* Les champs de recherche et le bouton "Filtrer" prennent toute la largeur */
        }
        
        /* On empêche la colonne "Actions" d'être écrasée dans le tableau */
        .actions-wrap {
            min-width: 100px; /* Force une largeur minimum pour que les boutons restent en ligne */
            justify-content: flex-start;
        }

        /* Ajustement de la pagination pour mobile */
        .pagination {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        .pagination-info {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Liste des Fournisseurs</div>
            <div class="card-subtitle">{{ $fournisseurs->total() }} fournisseurs trouvés</div>
        </div>
        @can('fournisseurs.creer')
        <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouveau Fournisseur
        </a>
        @endcan
    </div>

    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap">
            <div class="filter-wrap">
                <span class="filter-search-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                <input type="text" name="search" class="filter-input" placeholder="Rechercher un fournisseur..." value="{{ request('search') }}">
            </div>
            <select name="statut" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="actif" {{ request('statut')=='actif'?'selected':'' }}>Actif</option>
                <option value="inactif" {{ request('statut')=='inactif'?'selected':'' }}>Inactif</option>
                <option value="suspendu" {{ request('statut')=='suspendu'?'selected':'' }}>Suspendu</option>
                <option value="en_qualification" {{ request('statut')=='en_qualification'?'selected':'' }}>En qualification</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('fournisseurs.index') }}" class="btn btn-outline btn-sm" style="text-align:center;">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Raison Sociale</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Secteur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fournisseurs as $f)
                <tr>
                    <td><strong style="color:var(--bleu)">{{ $f->code_fournisseur }}</strong></td>
                    <td>
                        <div style="font-weight:600">{{ $f->raison_sociale }}</div>
                        <div style="font-size:11px;color:var(--gris)">{{ $f->forme_juridique }}</div>
                    </td>
                    <td>{{ $f->email ?? '—' }}</td>
                    <td>{{ $f->ville ?? '—' }}</td>
                    <td>{{ $f->secteur_activite ?? '—' }}</td>
                    <td><span class="badge badge-{{ $f->statut }}">{{ ucfirst(str_replace('_',' ',$f->statut)) }}</span></td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('fournisseurs.show', $f) }}" class="action-btn action-view" title="Voir">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @can('fournisseurs.modifier')
                            <a href="{{ route('fournisseurs.edit', $f) }}" class="action-btn action-edit" title="Modifier">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endcan
                            @can('fournisseurs.supprimer')
                            <form method="POST" action="{{ route('fournisseurs.destroy', $f) }}" onsubmit="return confirm('Archiver ce fournisseur ?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Archiver">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty-state">
                        <div class="empty-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                        <h4>Aucun fournisseur</h4>
                        <p>Commencez par ajouter votre premier fournisseur</p>
                        @can('fournisseurs.creer')
                        <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Ajouter
                        </a>
                        @endcan
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <div class="pagination-info">Affichage {{ $fournisseurs->firstItem() }} - {{ $fournisseurs->lastItem() }} sur {{ $fournisseurs->total() }}</div>
        <div class="pagination-links">{{ $fournisseurs->links() }}</div>
    </div>
</div>
@endsection