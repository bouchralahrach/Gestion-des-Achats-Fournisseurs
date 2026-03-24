@extends('layouts.app')
@section('title', 'Nouvel Utilisateur')
@section('page-title', 'Nouvel Utilisateur')
@section('breadcrumb') <a href="{{ route('users.index') }}">Utilisateurs</a> <span>›</span> Nouveau @endsection

@section('content')
<form method="POST" action="{{ route('users.store') }}">
@csrf
<div class="form-card">
    <div class="form-card-header"><div class="card-title">Informations de l'utilisateur</div></div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Nom <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Prénom <span style="color:red">*</span></label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Email <span style="color:red">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="user@srm-cs.ma" required>
                @error('email')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Département</label>
                <input type="text" name="departement" class="form-control" value="{{ old('departement') }}" placeholder="ex: DSI, DRH, DAF...">
            </div>
            <div class="form-group-inner">
                <label>Rôle <span style="color:red">*</span></label>
                <select name="role" class="form-control" required>
                    <option value="">-- Sélectionner un rôle --</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role')==$role->name?'selected':'' }}>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                @error('role')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Mot de passe <span style="color:red">*</span></label>
                <input type="password" name="password" class="form-control" required minlength="8">
                @error('password')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Confirmer mot de passe <span style="color:red">*</span></label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
    </div>
    <div class="form-card-footer">
        <a href="{{ route('users.index') }}" class="btn btn-outline">Annuler</a>
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Créer l'utilisateur
        </button>
    </div>
</div>
</form>
@endsection