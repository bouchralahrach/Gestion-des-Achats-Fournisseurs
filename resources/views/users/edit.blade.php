@extends('layouts.app')
@section('title', 'Modifier Utilisateur')
@section('page-title', 'Modifier Utilisateur')
@section('breadcrumb') <a href="{{ route('users.index') }}">Utilisateurs</a> <span>›</span> Modifier @endsection

@section('content')
<form method="POST" action="{{ route('users.update', $user) }}">
@csrf @method('PUT')
<div class="form-card">
    <div class="form-card-header"><div class="card-title">{{ $user->name }} {{ $user->prenom }}</div></div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Nom <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group-inner">
                <label>Prénom <span style="color:red">*</span></label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $user->prenom) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Email <span style="color:red">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                @error('email')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Département</label>
                <input type="text" name="departement" class="form-control" value="{{ old('departement', $user->departement) }}">
            </div>
            <div class="form-group-inner">
                <label>Rôle <span style="color:red">*</span></label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name)?'selected':'' }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="background:rgba(255,152,0,0.06);border:1px solid rgba(255,152,0,0.2);border-radius:10px;padding:16px;margin-bottom:20px">
            <div style="font-size:13px;font-weight:600;margin-bottom:12px;color:#E65100">⚠️ Changer le mot de passe (laisser vide pour ne pas changer)</div>
            <div class="form-row">
                <div class="form-group-inner">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="password" class="form-control" minlength="8">
                </div>
                <div class="form-group-inner">
                    <label>Confirmer</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="form-card-footer">
        <a href="{{ route('users.index') }}" class="btn btn-outline">Annuler</a>
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
            Mettre à jour
        </button>
    </div>
</div>
</form>
@endsection