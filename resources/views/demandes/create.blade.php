@extends('layouts.app')
@section('title', 'Nouvelle Demande')
@section('page-title', 'Nouvelle Demande d\'Achat')
@section('breadcrumb') <a href="{{ route('demandes.index') }}">Demandes</a> <span>›</span> Nouvelle @endsection

@push('styles')
<style>
    /* Sur mobile, on s'assure que les 3 boutons s'empilent bien */
    @media (max-width: 768px) {
        .form-card-footer {
            flex-direction: column-reverse; /* Soumettre en haut, Annuler en bas */
            gap: 12px;
        }
        .form-card-footer .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('demandes.store') }}">
@csrf
<div class="form-card">
    <div class="form-card-header">
        <div class="card-title">Informations de la demande</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Objet de la demande <span style="color:red">*</span></label>
                <input type="text" name="objet" class="form-control" value="{{ old('objet') }}" placeholder="Décrivez brièvement votre besoin..." required>
                @error('objet')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Description détaillée</label>
                <textarea name="description" class="form-control" placeholder="Détails supplémentaires...">{{ old('description') }}</textarea>
            </div>
        </div>
        <div class="form-row form-row-3">
            <div class="form-group-inner">
                <label>Quantité <span style="color:red">*</span></label>
                <input type="number" name="quantite" class="form-control" value="{{ old('quantite') }}" step="0.01" min="0.01" required>
                @error('quantite')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Unité de mesure <span style="color:red">*</span></label>
                <select name="unite_mesure" class="form-control" required>
                    <option value="unité">Unité</option>
                    <option value="kg">Kilogramme (kg)</option>
                    <option value="litre">Litre</option>
                    <option value="mètre">Mètre</option>
                    <option value="lot">Lot</option>
                    <option value="boîte">Boîte</option>
                    <option value="carton">Carton</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>Budget estimatif (MAD)</label>
                <input type="number" name="budget_estimatif" class="form-control" value="{{ old('budget_estimatif') }}" step="0.01" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Catégorie</label>
                <select name="categorie" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <option value="Fournitures bureau">Fournitures bureau</option>
                    <option value="Informatique">Informatique</option>
                    <option value="Matériel technique">Matériel technique</option>
                    <option value="Services">Services</option>
                    <option value="Travaux">Travaux</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>Centre de coût</label>
                <input type="text" name="centre_cout" class="form-control" value="{{ old('centre_cout') }}" placeholder="ex: DSI, DRH...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Date souhaitée</label>
                <input type="date" name="date_souhaitee" class="form-control" value="{{ old('date_souhaitee') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
        </div>
    </div>
    <div class="form-card-footer">
        <a href="{{ route('demandes.index') }}" class="btn btn-outline" style="text-align:center;">Annuler</a>
        <button type="submit" name="action" value="brouillon" class="btn btn-outline" style="text-align:center;">Enregistrer en brouillon</button>
        <button type="submit" name="action" value="soumettre" class="btn btn-primary" style="text-align:center;">
            <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Soumettre
        </button>
    </div>
</div>
</form>
@endsection