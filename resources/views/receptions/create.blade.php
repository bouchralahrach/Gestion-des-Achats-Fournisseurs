@extends('layouts.app')
@section('title', 'Nouveau BR')
@section('page-title', 'Nouveau Bon de Réception')
@section('breadcrumb') <a href="{{ route('receptions.index') }}">Réceptions</a> <span>›</span> Nouveau @endsection

@section('content')
<form method="POST" action="{{ route('receptions.store') }}">
@csrf
<div class="form-card">
    <div class="form-card-header">
        <div class="card-title">Informations de réception</div>
    </div>
    <div class="form-card-body">

        <div class="form-row">
            <div class="form-group-inner">
                <label>Bon de Commande <span style="color:red">*</span></label>
                <select name="bon_commande_id" class="form-control" required>
                    <option value="">-- Sélectionner un BC --</option>
                    @foreach($commandes as $bc)
                    <option value="{{ $bc->id }}" {{ (old('bon_commande_id', request('bon_commande_id'))==$bc->id)?'selected':'' }}>
                        {{ $bc->numero }} — {{ $bc->fournisseur->raison_sociale }}
                    </option>
                    @endforeach
                </select>
                @error('bon_commande_id')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Date de réception <span style="color:red">*</span></label>
                <input type="date" name="date_reception" class="form-control"
                       value="{{ old('date_reception', date('Y-m-d')) }}" required>
                @error('date_reception')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-inner">
                <label>N° livraison fournisseur</label>
                <input type="text" name="numero_livraison_fournisseur" class="form-control"
                       value="{{ old('numero_livraison_fournisseur') }}"
                       placeholder="Ex: BL-2024-001">
            </div>
            <div class="form-group-inner">
                <label>État des marchandises <span style="color:red">*</span></label>
                <select name="etat" class="form-control" required>
                    <option value="conforme" {{ old('etat')=='conforme'?'selected':'' }}>✅ Conforme</option>
                    <option value="non_conforme" {{ old('etat')=='non_conforme'?'selected':'' }}>❌ Non conforme</option>
                    <option value="avec_reserves" {{ old('etat')=='avec_reserves'?'selected':'' }}>⚠️ Avec réserves</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Observations & Remarques</label>
                <textarea name="observations" class="form-control"
                          placeholder="Détails sur la livraison, dommages, écarts...">{{ old('observations') }}</textarea>
            </div>
        </div>

    </div>
    <div class="form-card-footer">
        <a href="{{ route('receptions.index') }}" class="btn btn-outline">Annuler</a>
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
            Enregistrer la réception
        </button>
    </div>
</div>
</form>
@endsection