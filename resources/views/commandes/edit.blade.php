@extends('layouts.app')

@section('title', 'Modifier ' . $commande->numero)
@section('page-title', 'Modifier ' . $commande->numero)
@section('breadcrumb') Commandes / {{ $commande->numero }} / Modifier @endsection

@push('styles')
<style>
    /* --- CSS spécifique pour rendre le tableau de saisie responsive (identique à create) --- */
    
    @media (max-width: 992px) {
        /* On cache l'en-tête du tableau sur mobile */
        .table-wrap thead {
            display: none;
        }

        /* Chaque ligne (TR) devient une "carte" avec bordure */
        #lignesBody tr {
            display: block;
            border: 2px solid #EDF2F7;
            border-radius: 12px;
            margin-bottom: 16px;
            padding: 16px;
            background: white;
            position: relative; /* Pour positionner le bouton supprimer */
        }

        /* Chaque cellule (TD) s'affiche en bloc */
        #lignesBody td {
            display: block;
            border: none;
            padding: 8px 0;
            text-align: left !important;
        }

        /* Fausses étiquettes pour guider l'utilisateur sur mobile */
        #lignesBody td:nth-child(1)::before { content: "Désignation :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }
        #lignesBody td:nth-child(2)::before { content: "Quantité :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }
        #lignesBody td:nth-child(3)::before { content: "Unité :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }
        #lignesBody td:nth-child(4)::before { content: "Prix Unitaire (HT) :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }
        #lignesBody td:nth-child(5)::before { content: "Remise (%) :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }
        #lignesBody td:nth-child(6)::before { content: "Total Ligne (HT) :"; font-size: 11px; font-weight: 600; color: var(--gris); text-transform: uppercase; display: block; margin-bottom: 4px; }

        /* Le bouton supprimer se place en haut à droite de la "carte" */
        #lignesBody td:nth-child(7) {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0;
        }

        /* Forcer l'alignement des inputs sur mobile */
        .quantite, .prix, .remise { text-align: left !important; }

        /* --- Réorganisation du pied de tableau (Totaux) --- */
        .table-wrap tfoot {
            display: block;
            background: #FAFCFF;
            border-top: 2px solid #EDF2F7;
            padding: 16px;
        }
        .table-wrap tfoot tr { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #EDF2F7; padding: 12px 0; }
        .table-wrap tfoot tr:last-child { border-bottom: none; }
        .table-wrap tfoot td { display: block; padding: 0 !important; border: none !important; text-align: left !important; }
        .table-wrap tfoot td[colspan="5"] { font-size: 14px !important; } 
        .table-wrap tfoot td:last-child { display: none; } /* Cacher la colonne vide du bouton supprimer */
        
        /* Boutons de soumission en bas */
        .footer-actions {
            display: flex;
            flex-direction: column-reverse; /* Empile Annuler en bas, Créer en haut */
            gap: 12px;
        }
        .footer-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('commandes.update', $commande) }}" id="commandeForm">
    @csrf
    @method('PUT')

    <div class="form-card">
        <div class="form-card-header">
            <div class="card-title">Informations du bon de commande</div>
        </div>
        <div class="form-card-body">
            <div class="form-row form-row-2">
                <div class="form-group-inner">
                    <label for="fournisseur_id">Fournisseur *</label>
                    <select name="fournisseur_id" id="fournisseur_id" class="form-control @error('fournisseur_id') is-invalid @enderror" required>
                        <option value="">Sélectionner un fournisseur...</option>
                        @foreach($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ old('fournisseur_id', $commande->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>{{ $fournisseur->nom ?? $fournisseur->raison_sociale }}</option>
                        @endforeach
                    </select>
                    @error('fournisseur_id')
                        <div style="color: #E53E3E; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group-inner">
                    <label>TVA (%)</label>
                    <div style="padding: 10px 0; font-weight: 500;">{{ $commande->tva }}%</div>
                    <input type="hidden" name="tva" value="{{ $commande->tva }}">
                </div>
            </div>

            <div class="form-row form-row-3">
                <div class="form-group-inner">
                    <label for="date_livraison_prevue">Date de livraison prévue</label>
                    <input type="date" name="date_livraison_prevue" id="date_livraison_prevue" class="form-control" value="{{ old('date_livraison_prevue', $commande->date_livraison_prevue?->format('Y-m-d')) }}">
                </div>
                <div class="form-group-inner">
                    <label for="mode_paiement">Mode de paiement</label>
                    <select name="mode_paiement" id="mode_paiement" class="form-control">
                        <option value="">Sélectionner...</option>
                        <option value="cheque" {{ old('mode_paiement', $commande->mode_paiement) == 'cheque' ? 'selected' : '' }}>Chèque</option>
                        <option value="virement" {{ old('mode_paiement', $commande->mode_paiement) == 'virement' ? 'selected' : '' }}>Virement bancaire</option>
                        <option value="especes" {{ old('mode_paiement', $commande->mode_paiement) == 'especes' ? 'selected' : '' }}>Espèces</option>
                        <option value="traite" {{ old('mode_paiement', $commande->mode_paiement) == 'traite' ? 'selected' : '' }}>Traite</option>
                    </select>
                </div>
                <div class="form-group-inner">
                    <label>Statut</label>
                    <div style="padding: 10px 0;">
                        <span class="badge badge-{{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-inner" style="grid-column: span 2;">
                    <label for="lieu_livraison">Lieu de livraison</label>
                    <input type="text" name="lieu_livraison" id="lieu_livraison" class="form-control" value="{{ old('lieu_livraison', $commande->lieu_livraison) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-inner" style="grid-column: span 2;">
                    <label for="conditions_livraison">Conditions de livraison</label>
                    <textarea name="conditions_livraison" id="conditions_livraison" class="form-control" rows="2">{{ old('conditions_livraison', $commande->conditions_livraison) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-card" style="margin-top: 20px;">
        <div class="form-card-header">
            <div class="card-title">Lignes de commande</div>
            <button type="button" class="btn btn-outline btn-sm" id="addLigne">
                <svg viewBox="0 0 24 24" width="16" height="16"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Ajouter une ligne
            </button>
        </div>
        <div class="form-card-body">
            <div class="table-wrap">
                <table id="lignesTable">
                    <thead>
                        <tr>
                            <th>Désignation *</th>
                            <th style="width: 100px;">Quantité *</th>
                            <th style="width: 100px;">Unité</th>
                            <th style="width: 120px;">Prix Unitaire (MAD) *</th>
                            <th style="width: 80px;">Remise (%)</th>
                            <th style="width: 120px;">Total HT</th>
                            <th style="width: 60px;"></th>
                        </tr>
                    </thead>
                    <tbody id="lignesBody">
                        @if(old('lignes'))
                            @foreach(old('lignes') as $index => $ligne)
                            <tr>
                                <td>
                                    <input type="text" name="lignes[{{ $index }}][designation]" class="form-control" value="{{ $ligne['designation'] ?? '' }}" required>
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][quantite]" class="form-control quantite" value="{{ $ligne['quantite'] ?? '' }}" step="0.01" min="0.01" required>
                                </td>
                                <td>
                                    <input type="text" name="lignes[{{ $index }}][unite]" class="form-control" value="{{ $ligne['unite'] ?? 'unité' }}">
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][prix_unitaire]" class="form-control prix" value="{{ $ligne['prix_unitaire'] ?? '' }}" step="0.01" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][remise]" class="form-control remise" value="{{ $ligne['remise'] ?? 0 }}" step="0.01" min="0" max="100">
                                </td>
                                <td class="ligne-total">0,00 MAD</td>
                                <td>
                                    <button type="button" class="action-btn action-delete remove-ligne">
                                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            @foreach($commande->lignes as $index => $ligne)
                            <tr>
                                <td>
                                    <input type="text" name="lignes[{{ $index }}][designation]" class="form-control" value="{{ $ligne->designation }}" required>
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][quantite]" class="form-control quantite" value="{{ $ligne->quantite }}" step="0.01" min="0.01" required>
                                </td>
                                <td>
                                    <input type="text" name="lignes[{{ $index }}][unite]" class="form-control" value="{{ $ligne->unite }}">
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][prix_unitaire]" class="form-control prix" value="{{ $ligne->prix_unitaire }}" step="0.01" min="0" required>
                                </td>
                                <td>
                                    <input type="number" name="lignes[{{ $index }}][remise]" class="form-control remise" value="{{ $ligne->remise }}" step="0.01" min="0" max="100">
                                </td>
                                <td class="ligne-total">{{ number_format($ligne->montant_total, 2, ',', ' ') }} MAD</td>
                                <td>
                                    <button type="button" class="action-btn action-delete remove-ligne">
                                        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold;">Total HT :</td>
                            <td id="totalHt" style="font-weight: bold;">{{ number_format($commande->montant_ht, 2, ',', ' ') }} MAD</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold;">TVA ({{ $commande->tva }}%) :</td>
                            <td id="montantTva" style="font-weight: bold;">{{ number_format($commande->montant_ht * ($commande->tva / 100), 2, ',', ' ') }} MAD</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: bold; font-size: 1.1em;">Total TTC :</td>
                            <td id="totalTtc" style="font-weight: bold; font-size: 1.1em; color: var(--bleu-fonce);">{{ number_format($commande->montant_ttc, 2, ',', ' ') }} MAD</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @error('lignes')
                <div style="color: #E53E3E; font-size: 12px; margin-top: 8px;">{{ $message }}</div>
            @enderror
            @error('lignes.*')
                <div style="color: #E53E3E; font-size: 12px; margin-top: 8px;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-card-footer footer-actions" style="margin-top: 20px; display:flex; justify-content:space-between;">
        <a href="{{ route('commandes.show', $commande) }}" class="btn btn-outline">Annuler</a>
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Mettre à jour le Bon de Commande
        </button>
    </div>
</form>

@push('scripts')
<script>
let ligneIndex = {{ $commande->lignes->count() }};

document.getElementById('addLigne').addEventListener('click', function() {
    const tbody = document.getElementById('lignesBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="text" name="lignes[${ligneIndex}][designation]" class="form-control" placeholder="Désignation de l'article" required>
        </td>
        <td>
            <input type="number" name="lignes[${ligneIndex}][quantite]" class="form-control quantite" value="1" step="0.01" min="0.01" required>
        </td>
        <td>
            <input type="text" name="lignes[${ligneIndex}][unite]" class="form-control" value="unité">
        </td>
        <td>
            <input type="number" name="lignes[${ligneIndex}][prix_unitaire]" class="form-control prix" value="0" step="0.01" min="0" required>
        </td>
        <td>
            <input type="number" name="lignes[${ligneIndex}][remise]" class="form-control remise" value="0" step="0.01" min="0" max="100">
        </td>
        <td class="ligne-total">0,00 MAD</td>
        <td>
            <button type="button" class="action-btn action-delete remove-ligne">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </td>
    `;
    tbody.appendChild(tr);
    ligneIndex++;
    attachLigneListeners(tr);
    calculateTotals();
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-ligne')) {
        const row = e.target.closest('tr');
        if (document.querySelectorAll('#lignesBody tr').length > 1) {
            row.remove();
            calculateTotals();
        }
    }
});

function attachLigneListeners(row) {
    row.querySelectorAll('.quantite, .prix, .remise').forEach(input => {
        input.addEventListener('input', calculateTotals);
    });
}

function calculateTotals() {
    const tva = {{ $commande->tva }};
    let totalHt = 0;
    
    document.querySelectorAll('#lignesBody tr').forEach(row => {
        const qte = parseFloat(row.querySelector('.quantite').value) || 0;
        const prix = parseFloat(row.querySelector('.prix').value) || 0;
        const remise = parseFloat(row.querySelector('.remise').value) || 0;
        
        const ligneHt = qte * prix;
        const ligneApresRemise = ligneHt * (1 - remise / 100);
        totalHt += ligneApresRemise;
        
        row.querySelector('.ligne-total').textContent = ligneApresRemise.toFixed(2).replace('.', ',') + ' MAD';
    });
    
    const montantTva = totalHt * (tva / 100);
    const totalTtc = totalHt + montantTva;
    
    document.getElementById('totalHt').textContent = totalHt.toFixed(2).replace('.', ',') + ' MAD';
    document.getElementById('montantTva').textContent = montantTva.toFixed(2).replace('.', ',') + ' MAD';
    document.getElementById('totalTtc').textContent = totalTtc.toFixed(2).replace('.', ',') + ' MAD';
}

document.querySelectorAll('#lignesBody tr').forEach(attachLigneListeners);
calculateTotals();
</script>
@endpush

@endsection