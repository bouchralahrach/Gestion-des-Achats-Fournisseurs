<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande {{ $commande->numero }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .company-info {
            width: 50%;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .doc-info {
            width: 50%;
            text-align: right;
        }
        .doc-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .doc-number {
            font-size: 14px;
            color: #666;
        }
        .parties {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .party {
            width: 48%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .party-title {
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
        }
        .info-value {
            flex: 1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals {
            width: 300px;
            margin-left: auto;
            margin-bottom: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        .total-row.grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 5px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .signature-block {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-en_attente { background: #FFF3CD; color: #856404; }
        .badge-envoyee { background: #CCE5FF; color: #004085; }
        .badge-confirmee { background: #D4EDDA; color: #155724; }
        .badge-en_livraison { background: #E2E3E5; color: #383D41; }
        .badge-recue { background: #D1ECF1; color: #0C5460; }
        .badge-soldee { background: #D4EDDA; color: #155724; }
        .badge-annulee { background: #F8D7DA; color: #721C24; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">SGA-F</div>
            <div>Système de Gestion des Achats et Fournisseurs</div>
        </div>
        <div class="doc-info">
            <div class="doc-title">BON DE COMMANDE</div>
            <div class="doc-number">N° {{ $commande->numero }}</div>
            <div class="badge badge-{{ $commande->statut }}">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</div>
        </div>
    </div>

    <div class="parties">
        <div class="party">
            <div class="party-title">FOURNISSEUR</div>
            <div style="font-weight: bold; margin-bottom: 5px;">{{ $commande->fournisseur->nom ?? 'N/A' }}</div>
            @if($commande->fournisseur->adresse)
            <div>{{ $commande->fournisseur->adresse }}</div>
            @endif
            @if($commande->fournisseur->telephone)
            <div>Tél: {{ $commande->fournisseur->telephone }}</div>
            @endif
            @if($commande->fournisseur->email)
            <div>Email: {{ $commande->fournisseur->email }}</div>
            @endif
        </div>
        <div class="party">
            <div class="party-title">INFORMATIONS</div>
            <div class="info-row">
                <span class="info-label">Date:</span>
                <span class="info-value">{{ $commande->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date livraison:</span>
                <span class="info-value">{{ $commande->date_livraison_prevue ? $commande->date_livraison_prevue->format('d/m/Y') : 'Non définie' }}</span>
            </div>
            @if($commande->demandeAchat)
            <div class="info-row">
                <span class="info-label">Demande:</span>
                <span class="info-value">{{ $commande->demandeAchat->numero }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label">Mode paiement:</span>
                <span class="info-value">{{ $commande->mode_paiement ? ucfirst($commande->mode_paiement) : 'Non défini' }}</span>
            </div>
        </div>
    </div>

    @if($commande->lieu_livraison || $commande->conditions_livraison)
    <div style="margin-bottom: 20px;">
        @if($commande->lieu_livraison)
        <div><strong>Lieu de livraison:</strong> {{ $commande->lieu_livraison }}</div>
        @endif
        @if($commande->conditions_livraison)
        <div><strong>Conditions de livraison:</strong> {{ $commande->conditions_livraison }}</div>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Désignation</th>
                <th class="text-center" style="width: 10%;">Qté</th>
                <th class="text-center" style="width: 10%;">Unité</th>
                <th class="text-right" style="width: 15%;">P.U. (MAD)</th>
                <th class="text-center" style="width: 10%;">Remise</th>
                <th class="text-right" style="width: 15%;">Total HT (MAD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->lignes as $ligne)
            <tr>
                <td>{{ $ligne->designation }}</td>
                <td class="text-center">{{ number_format($ligne->quantite, 2, ',', ' ') }}</td>
                <td class="text-center">{{ $ligne->unite }}</td>
                <td class="text-right">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }}</td>
                <td class="text-center">{{ $ligne->remise }}%</td>
                <td class="text-right">{{ number_format($ligne->montant_total, 2, ',', ' ') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Total HT:</span>
            <span>{{ number_format($commande->montant_ht, 2, ',', ' ') }} MAD</span>
        </div>
        <div class="total-row">
            <span>TVA ({{ $commande->tva }}%):</span>
            <span>{{ number_format($commande->montant_ht * ($commande->tva / 100), 2, ',', ' ') }} MAD</span>
        </div>
        <div class="total-row grand-total">
            <span>Total TTC:</span>
            <span>{{ number_format($commande->montant_ttc, 2, ',', ' ') }} MAD</span>
        </div>
    </div>

    <div class="signature-block">
        <div class="signature-box">
            <div class="signature-line">Signature et cachet du fournisseur</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">Signature et cachet de l'entreprise</div>
        </div>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }} - SGA-F</p>
    </div>
</body>
</html>

