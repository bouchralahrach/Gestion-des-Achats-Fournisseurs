@extends('layouts.app')
@section('title', 'Modifier Fournisseur')
@section('page-title', 'Modifier Fournisseur')
@section('breadcrumb') <a href="{{ route('fournisseurs.index') }}">Fournisseurs</a> <span>›</span> Modifier @endsection

@section('content')
<form method="POST" action="{{ route('fournisseurs.update', $fournisseur) }}">
@csrf @method('PUT')

<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">{{ $fournisseur->raison_sociale }}</div>
        <span class="badge badge-{{ $fournisseur->statut }}">{{ ucfirst($fournisseur->statut) }}</span>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Raison sociale <span style="color:red">*</span></label>
                <input type="text" name="raison_sociale" class="form-control" value="{{ old('raison_sociale', $fournisseur->raison_sociale) }}" required>
            </div>
            <div class="form-group-inner">
                <label>Forme juridique</label>
                <select name="forme_juridique" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <option value="SARL" {{ old('forme_juridique',$fournisseur->forme_juridique)=='SARL'?'selected':'' }}>SARL</option>
                    <option value="SA" {{ old('forme_juridique',$fournisseur->forme_juridique)=='SA'?'selected':'' }}>SA</option>
                    <option value="SNC" {{ old('forme_juridique',$fournisseur->forme_juridique)=='SNC'?'selected':'' }}>SNC</option>
                    <option value="Auto-entrepreneur" {{ old('forme_juridique',$fournisseur->forme_juridique)=='Auto-entrepreneur'?'selected':'' }}>Auto-entrepreneur</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Statut</label>
                <select name="statut" class="form-control">
                    <option value="actif" {{ old('statut',$fournisseur->statut)=='actif'?'selected':'' }}>Actif</option>
                    <option value="inactif" {{ old('statut',$fournisseur->statut)=='inactif'?'selected':'' }}>Inactif</option>
                    <option value="suspendu" {{ old('statut',$fournisseur->statut)=='suspendu'?'selected':'' }}>Suspendu</option>
                    <option value="en_qualification" {{ old('statut',$fournisseur->statut)=='en_qualification'?'selected':'' }}>En qualification</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>Numéro registre</label>
                <input type="text" name="numero_registre" class="form-control" value="{{ old('numero_registre', $fournisseur->numero_registre) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $fournisseur->email) }}">
            </div>
            <div class="form-group-inner">
                <label>Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $fournisseur->telephone) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Adresse</label>
                <input type="text" name="adresse" class="form-control" value="{{ old('adresse', $fournisseur->adresse) }}">
            </div>
            <div class="form-group-inner">
                <label>Ville</label>
                <input type="text" name="ville" class="form-control" value="{{ old('ville', $fournisseur->ville) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Contact Nom</label>
                <input type="text" name="contact_nom" class="form-control" value="{{ old('contact_nom', $fournisseur->contact_nom) }}">
            </div>
            <div class="form-group-inner">
                <label>Contact Prénom</label>
                <input type="text" name="contact_prenom" class="form-control" value="{{ old('contact_prenom', $fournisseur->contact_prenom) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Banque</label>
                <input type="text" name="banque" class="form-control" value="{{ old('banque', $fournisseur->banque) }}">
            </div>
            <div class="form-group-inner">
                <label>Délai paiement (jours)</label>
                <input type="number" name="delai_paiement" class="form-control" value="{{ old('delai_paiement', $fournisseur->delai_paiement) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Secteur d'activité</label>
                <input type="text" name="secteur_activite" class="form-control" value="{{ old('secteur_activite', $fournisseur->secteur_activite) }}">
            </div>
            <div class="form-group-inner">
                <label>Devise</label>
                <select name="devise" class="form-control">
                    <option value="MAD" {{ old('devise',$fournisseur->devise)=='MAD'?'selected':'' }}>MAD</option>
                    <option value="EUR" {{ old('devise',$fournisseur->devise)=='EUR'?'selected':'' }}>EUR</option>
                    <option value="USD" {{ old('devise',$fournisseur->devise)=='USD'?'selected':'' }}>USD</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="form-card">
    <div class="form-card-footer">
        <a href="{{ route('fournisseurs.show', $fournisseur) }}" class="btn btn-outline" style="text-align: center; justify-content: center;">Annuler</a>
        <button type="submit" class="btn btn-primary" style="justify-content: center;">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Mettre à jour
        </button>
    </div>
</div>
</form>
@endsection