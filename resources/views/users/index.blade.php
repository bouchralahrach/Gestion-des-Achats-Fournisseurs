@extends('layouts.app')
@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')
@section('breadcrumb') Utilisateurs @endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Utilisateurs</div>
            <div class="card-subtitle">{{ $users->total() }} utilisateurs</div>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvel Utilisateur
        </a>
    </div>

    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap">
            <div class="filter-wrap">
                <span class="filter-search-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></span>
                <input type="text" name="search" class="filter-input" placeholder="Rechercher..." value="{{ request('search') }}">
            </div>
            <select name="role" class="filter-select">
                <option value="">Tous les rôles</option>
                @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ request('role')==$role->name?'selected':'' }}>{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Statut</th><th>Créé le</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:white;flex-shrink:0">
                                {{ strtoupper(substr($user->name,0,1)) }}{{ strtoupper(substr($user->prenom??'',0,1)) }}
                            </div>
                            <div>
                                <div style="font-weight:600">{{ $user->name }} {{ $user->prenom }}</div>
                                <div style="font-size:11px;color:var(--gris)">{{ $user->departement ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                        <span class="badge badge-soumise">{{ ucfirst($role->name) }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($user->is_active)
                        <span class="badge badge-actif">Actif</span>
                        @else
                        <span class="badge badge-inactif">Inactif</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('users.edit', $user) }}" class="action-btn action-edit" title="Modifier">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('users.toggle', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="action-btn {{ $user->is_active ? 'action-delete' : 'action-view' }}" title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                    <svg viewBox="0 0 24 24"><path d="{{ $user->is_active ? 'M18.36 6.64a9 9 0 1 1-12.73 0' : 'M12 2v10' }}"/></svg>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--gris);padding:40px">Aucun utilisateur trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <div class="pagination-info">{{ $users->firstItem() }} - {{ $users->lastItem() }} sur {{ $users->total() }}</div>
        <div>{{ $users->links() }}</div>
    </div>
</div>
@endsection