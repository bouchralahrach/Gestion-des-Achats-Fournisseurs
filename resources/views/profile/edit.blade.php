@extends('layouts.app')
@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')
@section('breadcrumb') Profil @endsection

@section('content')
<div class="form-card" style="max-width:700px;margin:0 auto">
    <div class="form-card-header">
        <div class="card-title">Informations personnelles</div>
    </div>
    <div class="form-card-body">

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="form-row">
                <div class="form-group-inner">
                    <label>Nom <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>
                <div class="form-group-inner">
                    <label>Prénom</label>
                    <input type="text" name="prenom" class="form-control"
                           value="{{ old('prenom', auth()->user()->prenom) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-inner">
                    <label>Adresse e-mail <span style="color:red">*</span></label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>
                <div class="form-group-inner">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control"
                           value="{{ old('telephone', auth()->user()->telephone) }}"
                           placeholder="Ex: 06 00 00 00 00">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-inner" style="grid-column:1/-1">
                    <label>Département</label>
                    <input type="text" name="departement" class="form-control"
                           value="{{ old('departement', auth()->user()->departement) }}"
                           placeholder="Ex: Direction Achats">
                </div>
            </div>

            <div class="form-card-footer" style="padding:18px 0 0;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                    Enregistrer
                </button>
            </div>
        </form>

    </div>
</div>

{{-- Changer mot de passe --}}
<div class="form-card" style="max-width:700px;margin:24px auto 0">
    <div class="form-card-header">
        <div class="card-title">Changer le mot de passe</div>
    </div>
    <div class="form-card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group-inner" style="grid-column:1/-1">
                    <label>Mot de passe actuel</label>
                    <input type="password" name="current_password" class="form-control"
                           placeholder="••••••••">
                    @error('current_password')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-inner">
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="••••••••">
                    @error('password')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
                </div>
                <div class="form-group-inner">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="form-card-footer" style="padding:18px 0 0;margin-top:8px">
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Changer le mot de passe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection