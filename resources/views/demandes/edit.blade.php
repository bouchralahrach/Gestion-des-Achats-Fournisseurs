@extends('layouts.app')
@section('title', 'Modifier Demande')
@section('page-title', 'Modifier la Demande')
@section('breadcrumb') <a href="{{ route('demandes.index') }}">Demandes</a> <span>›</span> Modifier @endsection

@section('content')
<form method="POST" action="{{ route('demandes.update', $demande) }}">
@csrf @method('PUT')
<div class="form-card">
    <div class="form-card-header">
        <div class="card-title">{{ $demande->numero }}</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Objet <span style="color:red">*</span></label>
                <input type="text" name="objet" class="form-control" value="{{ old('objet', $demande->objet) }}" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ old('description', $demande->description) }}</textarea>
            </div>
        </div>
        <div class="form-row form-row-3">
            <div class="form-group-inner">
                <label>Quantité <span style="color:red">*</span></label>
                <input type="number" name="quantite" class="form-control" value="{{ old('quantite', $demande->quantite) }}" step="0.01" min="0.01" required>
            </div>
            <div class="form-group-inner">
                <label>Unité de mesure <span style="color:red">*</span></label>
                <select name="unite_mesure" class="form-control" required>
                    <option value="unité" {{ old('unite_mesure',$demande->unite_mesure)=='unité'?'selected':'' }}>Unité</option>
                    <option value="kg" {{ old('unite_mesure',$demande->unite_mesure)=='kg'?'selected':'' }}>Kilogramme</option>
                    <option value="litre" {{ old('unite_mesure',$demande->unite_mesure)=='litre'?'selected':'' }}>Litre</option>
                    <option value="mètre" {{ old('unite_mesure',$demande->unite_mesure)=='mètre'?'selected':'' }}>Mètre</option>
                    <option value="lot" {{ old('unite_mesure',$demande->unite_mesure)=='lot'?'selected':'' }}>Lot</option>
                    <option value="boîte" {{ old('unite_mesure',$demande->unite_mesure)=='boîte'?'selected':'' }}>Boîte</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>Budget estimatif (MAD)</label>
                <input type="number" name="budget_estimatif" class="form-control" value="{{ old('budget_estimatif', $demande->budget_estimatif) }}" step="0.01" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Catégorie</label>
                <select name="categorie" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <option value="Fournitures bureau" {{ old('categorie',$demande->categorie)=='Fournitures bureau'?'selected':'' }}>Fournitures bureau</option>
                    <option value="Informatique" {{ old('categorie',$demande->categorie)=='Informatique'?'selected':'' }}>Informatique</option>
                    <option value="Matériel technique" {{ old('categorie',$demande->categorie)=='Matériel technique'?'selected':'' }}>Matériel technique</option>
                    <option value="Services" {{ old('categorie',$demande->categorie)=='Services'?'selected':'' }}>Services</option>
                    <option value="Travaux" {{ old('categorie',$demande->categorie)=='Travaux'?'selected':'' }}>Travaux</option>
                    <option value="Autre" {{ old('categorie',$demande->categorie)=='Autre'?'selected':'' }}>Autre</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>Centre de coût</label>
                <input type="text" name="centre_cout" class="form-control" value="{{ old('centre_cout', $demande->centre_cout) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Date souhaitée</label>
                <input type="date" name="date_souhaitee" class="form-control" value="{{ old('date_souhaitee', $demande->date_souhaitee?->format('Y-m-d')) }}">
            </div>
        </div>
    </div>
    <div class="form-card-footer">
        <a href="{{ route('demandes.show', $demande) }}" class="btn btn-outline" style="text-align: center; justify-content: center;">Annuler</a>
        <button type="submit" class="btn btn-primary" style="justify-content: center;">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
            Enregistrer
        </button>
    </div>
</div>
</form>
@endsection