@extends('layouts.app')
@section('title', 'Nouveau Fournisseur')
@section('page-title', 'Nouveau Fournisseur')
@section('breadcrumb') <a href="{{ route('fournisseurs.index') }}">Fournisseurs</a> <span>›</span> Nouveau @endsection

@section('content')
<form method="POST" action="{{ route('fournisseurs.store') }}">
@csrf

<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">Informations générales</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Raison sociale <span style="color:red">*</span></label>
                <input type="text" name="raison_sociale" class="form-control" value="{{ old('raison_sociale') }}" required>
                @error('raison_sociale')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Forme juridique</label>
                <select name="forme_juridique" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <option value="SARL" {{ old('forme_juridique')=='SARL'?'selected':'' }}>SARL</option>
                    <option value="SA" {{ old('forme_juridique')=='SA'?'selected':'' }}>SA</option>
                    <option value="SNC" {{ old('forme_juridique')=='SNC'?'selected':'' }}>SNC</option>
                    <option value="Auto-entrepreneur" {{ old('forme_juridique')=='Auto-entrepreneur'?'selected':'' }}>Auto-entrepreneur</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Numéro registre de commerce</label>
                <input type="text" name="numero_registre" class="form-control" value="{{ old('numero_registre') }}">
            </div>
            <div class="form-group-inner">
                <label>Statut <span style="color:red">*</span></label>
                <select name="statut" class="form-control" required>
                    <option value="actif" {{ old('statut')=='actif'?'selected':'' }}>Actif</option>
                    <option value="inactif" {{ old('statut')=='inactif'?'selected':'' }}>Inactif</option>
                    <option value="suspendu" {{ old('statut')=='suspendu'?'selected':'' }}>Suspendu</option>
                    <option value="en_qualification" {{ old('statut')=='en_qualification'?'selected':'' }}>En qualification</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Secteur d'activité</label>
                <input type="text" name="secteur_activite" class="form-control" value="{{ old('secteur_activite') }}" placeholder="ex: Informatique, BTP...">
            </div>
            <div class="form-group-inner">
                <label>Famille de produits/services</label>
                <input type="text" name="famille_produits" class="form-control" value="{{ old('famille_produits') }}">
            </div>
        </div>
    </div>
</div>

<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">Coordonnées</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                @error('email')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Adresse</label>
                <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}">
            </div>
            <div class="form-group-inner">
                <label>Ville</label>
                <input type="text" name="ville" class="form-control" value="{{ old('ville') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Pays</label>
                <input type="text" name="pays" class="form-control" value="{{ old('pays', 'Maroc') }}">
            </div>
            <div class="form-group-inner">
                <label>Site web</label>
                <input type="text" name="site_web" class="form-control" value="{{ old('site_web') }}" placeholder="https://...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Nom du contact</label>
                <input type="text" name="contact_nom" class="form-control" value="{{ old('contact_nom') }}">
            </div>
            <div class="form-group-inner">
                <label>Prénom du contact</label>
                <input type="text" name="contact_prenom" class="form-control" value="{{ old('contact_prenom') }}">
            </div>
        </div>
    </div>
</div>

<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">Informations bancaires & commerciales</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>RIB</label>
                <input type="text" name="rib" class="form-control" value="{{ old('rib') }}">
            </div>
            <div class="form-group-inner">
                <label>IBAN</label>
                <input type="text" name="iban" class="form-control" value="{{ old('iban') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Banque domiciliataire</label>
                <input type="text" name="banque" class="form-control" value="{{ old('banque') }}">
            </div>
            <div class="form-group-inner">
                <label>Délai de paiement (jours)</label>
                <input type="number" name="delai_paiement" class="form-control" value="{{ old('delai_paiement', 30) }}" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Devise</label>
                <select name="devise" class="form-control">
                    <option value="MAD" {{ old('devise','MAD')=='MAD'?'selected':'' }}>MAD - Dirham marocain</option>
                    <option value="EUR" {{ old('devise')=='EUR'?'selected':'' }}>EUR - Euro</option>
                    <option value="USD" {{ old('devise')=='USD'?'selected':'' }}>USD - Dollar</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="form-card">
    <div class="form-card-footer">
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-outline" style="text-align: center; justify-content: center;">Annuler</a>
        <button type="submit" class="btn btn-primary" style="justify-content: center;">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Enregistrer
        </button>
    </div>
</div>

</form>
@endsection