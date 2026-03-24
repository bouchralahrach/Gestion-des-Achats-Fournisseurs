@extends('layouts.app')

@section('title', 'Détails de l\'Utilisateur')
@section('page-title', 'Détails de l\'Utilisateur')
@section('breadcrumb') Utilisateurs / Détails @endsection

@section('content')

<div class="card">
    <div class="form-card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid var(--border-color);">
        <div>
            <h3 style="margin: 0; font-size: 20px; font-weight: 600;">{{ $user->name }} {{ $user->prenom }}</h3>
            <p style="margin: 4px 0 0; color: var(--gris); font-size: 14px;">{{ $user->email }}</p>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            @if($user->is_active)
            <span class="badge badge-actif">Actif</span>
            @else
            <span class="badge badge-inactif">Inactif</span>
            @endif
        </div>
    </div>

    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Nom</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->name }}</div>
            </div>
            <div class="form-group-inner">
                <label>Prénom</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->prenom ?? '—' }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-inner">
                <label>Email</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->email }}</div>
            </div>
            <div class="form-group-inner">
                <label>Téléphone</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->telephone ?? '—' }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-inner">
                <label>Département</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->departement ?? '—' }}</div>
            </div>
            <div class="form-group-inner">
                <label>Rôle(s)</label>
                <div style="padding: 10px 0;">
                    @foreach($user->roles as $role)
                    <span class="badge badge-actif">{{ $role->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-inner">
                <label>Créé le</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="form-group-inner">
                <label>Dernière modification</label>
                <div style="padding: 10px 0; font-weight: 500;">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <div class="form-card-footer" style="padding: 20px 24px; border-top: 1px solid var(--border-color); display: flex; gap: 12px;">
        <a href="{{ route('users.index') }}" class="btn btn-outline">
            <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Retour à la liste
        </a>
        @can('users.modifier')
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Modifier
        </a>
        @endcan
    </div>
</div>

@endsection

