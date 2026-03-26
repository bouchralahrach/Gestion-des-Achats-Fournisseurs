@extends('layouts.app')
@section('title', 'Journal d\'Audit')
@section('page-title', 'Journal d\'Audit')
@section('breadcrumb') Journal d'Audit @endsection

@push('styles')
<style>
    /* CSS spécifique pour améliorer l'affichage sur mobile du Journal d'Audit */
    @media (max-width: 768px) {
        .filters-bar form {
            flex-direction: column;
            width: 100%;
        }
        /* On s'assure que tous les champs de filtre (y compris les dates) prennent toute la largeur */
        .filter-wrap, .filter-select, .btn-sm {
            width: 100%;
            box-sizing: border-box;
        }
        
        /* Ajustement de la pagination */
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
            <div class="card-title">Journal d'Audit</div>
            <div class="card-subtitle">Traçabilité complète de toutes les opérations</div>
        </div>
    </div>

    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap">
            <div class="filter-wrap">
                <span class="filter-search-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                <input type="text" name="search" class="filter-input" placeholder="Rechercher une action..." value="{{ request('search') }}">
            </div>
            <select name="action" class="filter-select">
                <option value="">Toutes les actions</option>
                <option value="created">Créé</option>
                <option value="updated">Modifié</option>
                <option value="deleted">Supprimé</option>
                <option value="approuvee">Approuvé</option>
                <option value="rejetee">Rejeté</option>
            </select>
            <input type="date" name="date_debut" class="filter-select" value="{{ request('date_debut') }}" placeholder="Date début">
            <input type="date" name="date_fin" class="filter-select" value="{{ request('date_fin') }}" placeholder="Date fin">
            
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('audit.index') }}" class="btn btn-outline btn-sm" style="text-align: center;">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Date/Heure</th><th>Utilisateur</th><th>Action</th><th>Objet</th><th>IP</th><th>Détail</th></tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="white-space:nowrap">
                        <div style="font-weight:600">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div style="font-size:11px;color:var(--gris)">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>{{ $log->user ? $log->user->name : 'Système' }}</td>
                    <td>
                        @php
                            $colors = ['created'=>'badge-actif','updated'=>'badge-soumise','deleted'=>'badge-rejetee','approuvee'=>'badge-actif','rejetee'=>'badge-rejetee','annulee'=>'badge-annulee'];
                            $class = $colors[$log->action] ?? 'badge-brouillon';
                        @endphp
                        <span class="badge {{ $class }}">{{ ucfirst($log->action) }}</span>
                    </td>
                    <td>
                        <div style="font-size:12px;color:var(--gris)">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
                    </td>
                    <td style="font-size:12px;color:var(--gris)">{{ $log->ip_address }}</td>
                    <td>
                        <a href="{{ route('audit.show', $log) }}" class="action-btn action-view">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--gris);padding:40px">Aucune entrée dans le journal</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <div class="pagination-info">{{ $logs->firstItem() }} - {{ $logs->lastItem() }} sur {{ $logs->total() }}</div>
        <div>{{ $logs->links() }}</div>
    </div>
</div>
@endsection