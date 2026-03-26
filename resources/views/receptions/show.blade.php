@extends('layouts.app')
@section('title', 'BR: ' . $reception->numero)
@section('page-title', 'Détails de Réception')
@section('breadcrumb')
    <a href="{{ route('receptions.index') }}">Réceptions</a> <span>›</span> {{ $reception->numero }}
@endsection

@push('styles')
<style>
    /* --- Structure globale de la page Show (Réceptions) --- */
    .br-show-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }
    
    /* Grille des informations (Fournisseur, Date, etc.) */
    .br-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 24px;
    }

    /* Grille des signatures */
    .br-signatures-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        padding: 28px;
    }

    /* --- MEDIA QUERIES --- */
    @media (max-width: 992px) {
        /* Sur tablette, on empile les colonnes : Détails en haut, Actions/Infos en bas */
        .br-show-layout {
            grid-template-columns: 1fr; 
        }
    }

    @media (max-width: 576px) {
        /* Sur téléphone, on empile les informations de l'en-tête */
        .br-info-grid {
            grid-template-columns: 1fr;
            padding: 16px;
            gap: 16px;
        }

        /* On empile aussi les signatures pour qu'elles aient de la place */
        .br-signatures-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 16px;
        }

        /* Ajustement de l'en-tête de la carte pour éviter que le titre et le statut ne se chevauchent */
        .card-header-flex {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="br-show-layout">

    <div style="display:flex;flex-direction:column;gap:20px">

        {{-- EN-TÊTE BR --}}
        <div class="card">
            <div class="card-header card-header-flex" style="border-left:4px solid var(--bleu);padding-left:20px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div class="card-title">{{ $reception->numero }}</div>
                    <div class="card-subtitle">Réception du {{ \Carbon\Carbon::parse($reception->date_reception)->format('d/m/Y') }}</div>
                </div>
                <span class="badge badge-{{ $reception->etat }}" style="font-size:13px;padding:6px 14px">
                    {{ ucfirst(str_replace('_',' ',$reception->etat)) }}
                </span>
            </div>
            
            <div class="br-info-grid">
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Date de réception</div>
                    <div style="font-weight:600">{{ \Carbon\Carbon::parse($reception->date_reception)->format('d/m/Y') }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Réceptionnaire</div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700">
                            {{ strtoupper(substr($reception->receptionnaire->name,0,1)) }}
                        </div>
                        <span style="font-weight:600">{{ $reception->receptionnaire->name }} {{ $reception->receptionnaire->prenom }}</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Fournisseur</div>
                    <div style="font-weight:600">{{ $reception->bonCommande->fournisseur->raison_sociale }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">N° Livraison fournisseur</div>
                    <div>{{ $reception->numero_livraison_fournisseur ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Bon de Commande lié</div>
                    <a href="{{ route('commandes.show', $reception->bonCommande) }}"
                       style="color:var(--bleu);font-weight:700;text-decoration:none;display:flex;align-items:center;gap:4px">
                        {{ $reception->bonCommande->numero }}
                        <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Statut commande</div>
                    <span class="badge badge-{{ $reception->bonCommande->statut }}">
                        {{ ucfirst(str_replace('_',' ',$reception->bonCommande->statut)) }}
                    </span>
                </div>

                @if($reception->observations)
                <div style="grid-column:1/-1">
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Observations</div>
                    <div style="background:var(--bg);padding:14px;border-radius:8px;font-size:13px;line-height:1.6;border:1px solid #EDF2F7;font-style:italic">
                        "{{ $reception->observations }}"
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ARTICLES RÉCEPTIONNÉS --}}
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
                <div>
                    <div class="card-title">Articles & Services Réceptionnés</div>
                    <div class="card-subtitle">Depuis le bon de commande {{ $reception->bonCommande->numero }}</div>
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Quantité</th>
                            <th>Unité</th>
                            <th>Prix unitaire HT</th>
                            <th>Total HT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reception->bonCommande->lignes as $ligne)
                        <tr>
                            <td style="font-weight:500">{{ $ligne->designation }}</td>
                            <td>{{ number_format($ligne->quantite,2,',',' ') }}</td>
                            <td style="color:var(--gris)">{{ $ligne->unite }}</td>
                            <td style="white-space:nowrap">{{ number_format($ligne->prix_unitaire,2,',',' ') }} MAD</td>
                            <td style="white-space:nowrap"><strong>{{ number_format($ligne->montant_total,2,',',' ') }} MAD</strong></td>
                        </tr>
                        @empty
                        <tr><td colspan="5">
                            <div style="text-align:center;padding:24px;color:var(--gris);font-size:13px">
                                Aucun article
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr style="background:#FAFCFF">
                            <td colspan="4" style="text-align:right;padding:12px 20px;font-weight:600;color:var(--gris)">Montant HT</td>
                            <td style="padding:12px 20px;font-weight:600;white-space:nowrap">{{ number_format($reception->bonCommande->montant_ht,2,',',' ') }} MAD</td>
                        </tr>
                        <tr style="background:#FAFCFF">
                            <td colspan="4" style="text-align:right;padding:12px 20px;color:var(--gris)">TVA ({{ $reception->bonCommande->tva }}%)</td>
                            <td style="padding:12px 20px;white-space:nowrap">{{ number_format($reception->bonCommande->montant_ttc - $reception->bonCommande->montant_ht,2,',',' ') }} MAD</td>
                        </tr>
                        <tr style="background:rgba(83,187,90,0.05)">
                            <td colspan="4" style="text-align:right;padding:14px 20px;font-weight:700;font-size:15px">Total TTC</td>
                            <td style="padding:14px 20px;font-weight:800;font-size:16px;color:var(--vert);white-space:nowrap">
                                {{ number_format($reception->bonCommande->montant_ttc,2,',',' ') }} MAD
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- SIGNATURES --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Signatures</div>
            </div>
            <div class="br-signatures-grid">
                <div style="text-align:center">
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Signature Fournisseur (Livreur)</div>
                    <div style="height:80px;border-bottom:2px dashed #EDF2F7;margin-bottom:12px"></div>
                    <div style="font-size:11px;color:var(--gris);font-style:italic">Cachet et Signature</div>
                </div>
                <div style="text-align:center">
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">Signature SGAF (Réceptionnaire)</div>
                    <div style="height:80px;border-bottom:2px dashed #EDF2F7;margin-bottom:12px"></div>
                    <div style="font-size:11px;color:var(--gris);font-style:italic">{{ $reception->receptionnaire->name }} {{ $reception->receptionnaire->prenom }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- COLONNE DROITE --}}
    <div style="display:flex;flex-direction:column;gap:16px">
        
        {{-- ACTIONS --}}
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
                <div class="card-title">Actions</div>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:10px">

                <button onclick="window.print()" class="btn btn-outline" style="justify-content:center">
                    <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Imprimer
                </button>

                @can('br.modifier')
                <a href="{{ route('receptions.edit', $reception) }}" class="btn btn-outline" style="justify-content:center">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modifier
                </a>
                @endcan

                <a href="{{ route('receptions.index') }}" class="btn btn-outline" style="justify-content:center">
                    ← Retour
                </a>
            </div>
        </div>

        {{-- INFOS --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informations</div>
            </div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Numéro BR</span>
                    <span style="font-weight:600;color:var(--bleu)">{{ $reception->numero }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">État</span>
                    <span class="badge badge-{{ $reception->etat }}">{{ ucfirst(str_replace('_',' ',$reception->etat)) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Date réception</span>
                    <span>{{ \Carbon\Carbon::parse($reception->date_reception)->format('d/m/Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">BC lié</span>
                    <span style="font-weight:600;color:var(--bleu)">{{ $reception->bonCommande->numero }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Montant TTC</span>
                    <span style="font-weight:700;color:var(--vert)">{{ number_format($reception->bonCommande->montant_ttc,2,',',' ') }} MAD</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection