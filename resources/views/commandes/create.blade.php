@extends('layouts.app')
@section('title', 'Nouveau Bon de Commande')
@section('page-title', 'Nouveau Bon de Commande')
@section('breadcrumb')
    <a href="{{ route('commandes.index') }}">Commandes</a> <span>›</span> Nouveau
@endsection

@section('content')
<form method="POST" action="{{ route('commandes.store') }}" id="form-commande">
@csrf

{{-- INFORMATIONS GÉNÉRALES --}}
<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">Informations Générales</div>
    </div>
    <div class="form-card-body">
        <div class="form-row">
            <div class="form-group-inner">
                <label>Fournisseur <span style="color:red">*</span></label>
                <select name="fournisseur_id" id="fournisseur_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($fournisseurs as $f)
                    <option value="{{ $f->id }}" {{ old('fournisseur_id')==$f->id?'selected':'' }}>
                        {{ $f->raison_sociale }} ({{ $f->code_fournisseur }})
                    </option>
                    @endforeach
                </select>
                @error('fournisseur_id')<div style="color:red;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
            </div>
            <div class="form-group-inner">
                <label>Demande d'achat liée</label>
                <select name="demande_achat_id" class="form-control">
                    <option value="">-- Aucune --</option>
                    @foreach($demandes as $da)
                    <option value="{{ $da->id }}" {{ (old('demande_achat_id') ?? ($demande->id ?? '')) == $da->id ? 'selected' : '' }}>
                        {{ $da->numero }} — {{ Str::limit($da->objet, 30) }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Mode de paiement</label>
                <select name="mode_paiement" class="form-control">
                    <option value="">-- Sélectionner --</option>
                    <option value="Virement bancaire" {{ old('mode_paiement')=='Virement bancaire'?'selected':'' }}>Virement bancaire</option>
                    <option value="Chèque" {{ old('mode_paiement')=='Chèque'?'selected':'' }}>Chèque</option>
                    <option value="Traite" {{ old('mode_paiement')=='Traite'?'selected':'' }}>Traite</option>
                    <option value="Espèces" {{ old('mode_paiement')=='Espèces'?'selected':'' }}>Espèces</option>
                </select>
            </div>
            <div class="form-group-inner">
                <label>TVA <span style="color:red">*</span></label>
                <select name="tva" id="tva" class="form-control" required onchange="calculerTVA()">
                    <option value="0">0%</option>
                    <option value="7">7%</option>
                    <option value="10">10%</option>
                    <option value="14">14%</option>
                    <option value="20" selected>20%</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner">
                <label>Date de livraison prévue</label>
                <input type="date" name="date_livraison_prevue" class="form-control"
                       value="{{ old('date_livraison_prevue') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            <div class="form-group-inner">
                <label>Lieu de livraison</label>
                <input type="text" name="lieu_livraison" class="form-control"
                       value="{{ old('lieu_livraison') }}"
                       placeholder="ex: Siège SRM, Mohammedia">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group-inner" style="grid-column:1/-1">
                <label>Conditions de livraison</label>
                <input type="text" name="conditions_livraison" class="form-control"
                       value="{{ old('conditions_livraison') }}"
                       placeholder="ex: Franco, DDP...">
            </div>
        </div>
    </div>
</div>

{{-- LIGNES DE COMMANDE --}}
<div class="form-card" style="margin-bottom:20px">
    <div class="form-card-header">
        <div class="card-title">
            Lignes de Commande
            <span id="nb-lignes" style="background:rgba(45,155,214,0.1);color:var(--bleu);font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;margin-left:10px">1 ligne</span>
        </div>
        <button type="button" onclick="ajouterLigne()" class="btn btn-success btn-sm">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Ajouter une ligne
        </button>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="min-width:280px">Désignation</th>
                    <th style="width:90px;text-align:center">Qté</th>
                    <th style="width:110px;text-align:center">Unité</th>
                    <th style="width:140px;text-align:right">P.U (HT)</th>
                    <th style="width:90px;text-align:center">Remise %</th>
                    <th style="width:150px;text-align:right">Total HT</th>
                    <th style="width:50px"></th>
                </tr>
            </thead>
            <tbody id="lignes-body">
                <tr id="ligne-0">
                    <td>
                        <input type="text" name="lignes[0][designation]" class="form-control" required placeholder="Description...">
                    </td>
                    <td>
                        <input type="number" name="lignes[0][quantite]" class="qte form-control" style="text-align:center" step="0.01" min="0.01" required value="1" onchange="calculerLigne(0)">
                    </td>
                    <td>
                        <select name="lignes[0][unite]" class="form-control">
                            <option value="Unité">Unité</option>
                            <option value="kg">kg</option>
                            <option value="Litre">Litre</option>
                            <option value="Mètre">Mètre</option>
                            <option value="Lot">Lot</option>
                            <option value="Pce">Pce</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="lignes[0][prix_unitaire]" class="pu form-control" style="text-align:right" step="0.01" min="0" required value="0" onchange="calculerLigne(0)">
                    </td>
                    <td>
                        <input type="number" name="lignes[0][remise]" class="remise form-control" style="text-align:center" step="0.01" min="0" max="100" value="0" onchange="calculerLigne(0)">
                    </td>
                    <td style="text-align:right">
                        <input type="text" id="total-0" class="total-ligne form-control" style="text-align:right;font-weight:700;color:var(--bleu);background:rgba(45,155,214,0.05)" readonly value="0.00">
                    </td>
                    <td style="text-align:center">
                        <button type="button" onclick="supprimerLigne(0)" class="action-btn action-delete">
                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                        </button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="background:#FAFCFF">
                    <td colspan="5" style="text-align:right;padding:12px 18px;font-weight:600;color:var(--gris);font-size:12px">Total Hors Taxe</td>
                    <td style="padding:12px 18px;font-weight:700"><span id="grand-total">0.00 MAD</span></td>
                    <td></td>
                </tr>
                <tr style="background:#FAFCFF">
                    <td colspan="5" style="text-align:right;padding:12px 18px;color:var(--gris);font-size:12px">TVA (<span id="tva-display">20</span>%)</td>
                    <td style="padding:12px 18px"><span id="total-tva">0.00 MAD</span></td>
                    <td></td>
                </tr>
                <tr style="background:rgba(83,187,90,0.05)">
                    <td colspan="5" style="text-align:right;padding:14px 18px;font-weight:700;font-size:14px">Total TTC</td>
                    <td style="padding:14px 18px;font-weight:800;font-size:16px;color:var(--vert)"><span id="grand-total-ttc">0.00 MAD</span></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- FOOTER --}}
<div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0">
    <a href="{{ route('commandes.index') }}" class="btn btn-outline">
        <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Annuler
    </a>
    <button type="submit" class="btn btn-primary" style="padding:12px 32px">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        Créer le Bon de Commande
    </button>
</div>

</form>

@push('scripts')
<script>
let nbLignes = 1;

function ajouterLigne() {
    const i = nbLignes++;
    const tbody = document.getElementById('lignes-body');
    const tr = document.createElement('tr');
    tr.id = `ligne-${i}`;
    tr.innerHTML = `
        <td><input type="text" name="lignes[${i}][designation]" class="form-control" required placeholder="Description..."></td>
        <td><input type="number" name="lignes[${i}][quantite]" class="qte form-control" style="text-align:center" step="0.01" min="0.01" required value="1" onchange="calculerLigne(${i})"></td>
        <td>
            <select name="lignes[${i}][unite]" class="form-control">
                <option value="Unité">Unité</option>
                <option value="kg">kg</option>
                <option value="Litre">Litre</option>
                <option value="Mètre">Mètre</option>
                <option value="Lot">Lot</option>
                <option value="Pce">Pce</option>
            </select>
        </td>
        <td><input type="number" name="lignes[${i}][prix_unitaire]" class="pu form-control" style="text-align:right" step="0.01" min="0" required value="0" onchange="calculerLigne(${i})"></td>
        <td><input type="number" name="lignes[${i}][remise]" class="remise form-control" style="text-align:center" step="0.01" min="0" max="100" value="0" onchange="calculerLigne(${i})"></td>
        <td style="text-align:right"><input type="text" id="total-${i}" class="total-ligne form-control" style="text-align:right;font-weight:700;color:var(--bleu);background:rgba(45,155,214,0.05)" readonly value="0.00"></td>
        <td style="text-align:center">
            <button type="button" onclick="supprimerLigne(${i})" class="action-btn action-delete">
                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
            </button>
        </td>
    `;
    tbody.appendChild(tr);
    mettreAJourNombreLignes();
}

function supprimerLigne(i) {
    if (document.querySelectorAll('#lignes-body tr').length <= 1) {
        alert('La commande doit avoir au moins une ligne !');
        return;
    }
    if (confirm('Supprimer cette ligne ?')) {
        document.getElementById(`ligne-${i}`).remove();
        calculerTotal();
        mettreAJourNombreLignes();
    }
}

function mettreAJourNombreLignes() {
    const count = document.querySelectorAll('#lignes-body tr').length;
    document.getElementById('nb-lignes').textContent = `${count} ligne${count > 1 ? 's' : ''}`;
}

function calculerLigne(i) {
    const tr = document.getElementById(`ligne-${i}`);
    if (!tr) return;
    const qte = parseFloat(tr.querySelector('.qte').value) || 0;
    const pu  = parseFloat(tr.querySelector('.pu').value) || 0;
    const rem = parseFloat(tr.querySelector('.remise').value) || 0;
    const totalLigne = (qte * pu) * (1 - rem / 100);
    document.getElementById(`total-${i}`).value = totalLigne.toFixed(2);
    calculerTotal();
}

function calculerTVA() {
    document.getElementById('tva-display').textContent = document.getElementById('tva').value;
    calculerTotal();
}

function calculerTotal() {
    let totalHT = 0;
    document.querySelectorAll('#lignes-body .total-ligne').forEach(input => {
        totalHT += parseFloat(input.value) || 0;
    });
    const tvaRate = parseFloat(document.getElementById('tva').value) || 0;
    const totalTVA = totalHT * (tvaRate / 100);
    const totalTTC = totalHT + totalTVA;
    document.getElementById('grand-total').textContent = totalHT.toFixed(2) + ' MAD';
    document.getElementById('total-tva').textContent = totalTVA.toFixed(2) + ' MAD';
    document.getElementById('grand-total-ttc').textContent = totalTTC.toFixed(2) + ' MAD';
}
</script>
@endpush
@endsection