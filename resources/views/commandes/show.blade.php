@extends('layouts.app')
@section('title', $commande->numero)
@section('page-title', 'Bon de Commande ' . $commande->numero)
@section('breadcrumb')
    <a href="{{ route('commandes.index') }}">Commandes</a> <span>›</span> {{ $commande->numero }}
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">

    <div style="display:flex;flex-direction:column;gap:20px">

        {{-- EN-TÊTE BC --}}
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--vert);padding-left:20px">
                <div>
                    <div class="card-title">{{ $commande->numero }}</div>
                    <div class="card-subtitle">Créé le {{ $commande->created_at->format('d/m/Y à H:i') }} par {{ $commande->createdBy->name }}</div>
                </div>
                <span class="badge badge-{{ $commande->statut }}" style="font-size:13px;padding:6px 14px">
                    {{ ucfirst(str_replace('_',' ',$commande->statut)) }}
                </span>
            </div>
            <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Fournisseur</div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0">
                            {{ strtoupper(substr($commande->fournisseur->raison_sociale,0,2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:13px">{{ $commande->fournisseur->raison_sociale }}</div>
                            <div style="font-size:11px;color:var(--gris)">{{ $commande->fournisseur->code_fournisseur }}</div>
                        </div>
                    </div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Mode de paiement</div>
                    <div style="font-weight:500">{{ $commande->mode_paiement ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Livraison prévue</div>
                    <div style="font-weight:500">{{ $commande->date_livraison_prevue ? \Carbon\Carbon::parse($commande->date_livraison_prevue)->format('d/m/Y') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Lieu de livraison</div>
                    <div style="font-weight:500">{{ $commande->lieu_livraison ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Conditions de livraison</div>
                    <div style="font-weight:500">{{ $commande->conditions_livraison ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Date d'envoi</div>
                    <div style="font-weight:500">{{ $commande->date_envoi ? \Carbon\Carbon::parse($commande->date_envoi)->format('d/m/Y') : '—' }}</div>
                </div>
            </div>
        </div>

        {{-- LIGNES DE COMMANDE --}}
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
                <div class="card-title">Lignes de commande</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th>Qté</th>
                            <th>Unité</th>
                            <th>Prix unitaire</th>
                            <th>Remise</th>
                            <th>Total HT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commande->lignes as $ligne)
                        <tr>
                            <td style="font-weight:500">{{ $ligne->designation }}</td>
                            <td>{{ $ligne->quantite }}</td>
                            <td style="color:var(--gris)">{{ $ligne->unite }}</td>
                            <td>{{ number_format($ligne->prix_unitaire,2,',',' ') }} MAD</td>
                            <td>
                                @if($ligne->remise > 0)
                                    <span style="background:rgba(241,151,65,0.1);color:var(--orange-dark);padding:2px 8px;border-radius:5px;font-size:12px">
                                        {{ $ligne->remise }}%
                                    </span>
                                @else
                                    <span style="color:var(--gris)">—</span>
                                @endif
                            </td>
                            <td><strong style="color:var(--texte)">{{ number_format($ligne->montant_total,2,',',' ') }} MAD</strong></td>
                        </tr>
                        @empty
                        <tr><td colspan="6">
                            <div style="text-align:center;padding:24px;color:var(--gris);font-size:13px">
                                Aucune ligne de commande
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr style="background:#FAFCFF">
                            <td colspan="5" style="text-align:right;padding:12px 20px;font-weight:600;color:var(--gris)">Montant HT</td>
                            <td style="padding:12px 20px;font-weight:600">{{ number_format($commande->montant_ht,2,',',' ') }} MAD</td>
                        </tr>
                        <tr style="background:#FAFCFF">
                            <td colspan="5" style="text-align:right;padding:12px 20px;color:var(--gris)">TVA ({{ $commande->tva }}%)</td>
                            <td style="padding:12px 20px">{{ number_format($commande->montant_ttc - $commande->montant_ht,2,',',' ') }} MAD</td>
                        </tr>
                        <tr style="background:rgba(83,187,90,0.05)">
                            <td colspan="5" style="text-align:right;padding:14px 20px;font-weight:700;font-size:15px">Total TTC</td>
                            <td style="padding:14px 20px;font-weight:700;font-size:16px;color:var(--vert)">
                                {{ number_format($commande->montant_ttc,2,',',' ') }} MAD
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- RÉCEPTIONS LIÉES --}}
        @if($commande->bonsReception->count() > 0)
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--bleu);padding-left:20px">
                <div class="card-title">Bons de Réception liés</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Date</th>
                            <th>État</th>
                            <th>Réceptionnaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commande->bonsReception as $br)
                        <tr>
                            <td><strong style="color:var(--bleu)">{{ $br->numero }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($br->date_reception)->format('d/m/Y') }}</td>
                            <td><span class="badge badge-{{ $br->etat }}">{{ ucfirst(str_replace('_',' ',$br->etat)) }}</span></td>
                            <td>{{ $br->receptionnaire->name }}</td>
                            <td>
                                <a href="{{ route('receptions.show', $br) }}" class="action-btn action-view">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{-- ACTIONS --}}
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
                <div class="card-title">Actions</div>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:10px">

                {{-- Export PDF --}}
                <a href="{{ route('commandes.exportPdf', $commande) }}" class="btn btn-outline" style="justify-content:center" target="_blank">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Exporter PDF
                </a>

                {{-- Valider --}}
                @can('bc.valider')
                @if($commande->statut == 'en_attente')
                <form method="POST" action="{{ route('commandes.valider', $commande) }}">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Valider la commande
                    </button>
                </form>
                @endif
                @endcan

                {{-- Envoyer --}}
                @can('bc.envoyer')
                @if($commande->statut == 'confirmee')
                <form method="POST" action="{{ route('commandes.envoyer', $commande) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Envoyer au fournisseur
                    </button>
                </form>
                @endif
                @endcan

                {{-- Modifier --}}
                @can('bc.creer')
                @if(in_array($commande->statut, ['en_attente','confirmee']))
                <a href="{{ route('commandes.edit', $commande) }}" class="btn btn-outline" style="justify-content:center">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modifier
                </a>
                @endif
                @endcan

                {{-- Annuler --}}
                @can('bc.creer')
                @if(!in_array($commande->statut, ['annulee','soldee']))
                <form method="POST" action="{{ route('commandes.annuler', $commande) }}"
                      onsubmit="return confirm('Annuler ce bon de commande ?')">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width:100%;justify-content:center;color:#E53E3E;border-color:#E53E3E">
                        Annuler la commande
                    </button>
                </form>
                @endif
                @endcan

                <a href="{{ route('commandes.index') }}" class="btn btn-outline" style="justify-content:center">
                    ← Retour
                </a>
            </div>
        </div>

        {{-- RÉSUMÉ FINANCIER --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Résumé financier</div>
            </div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:12px">
                <div style="display:flex;justify-content:space-between;font-size:13px;padding-bottom:8px;border-bottom:1px solid #EDF2F7">
                    <span style="color:var(--gris)">Montant HT</span>
                    <span style="font-weight:600">{{ number_format($commande->montant_ht,2,',',' ') }} MAD</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;padding-bottom:8px;border-bottom:1px solid #EDF2F7">
                    <span style="color:var(--gris)">TVA ({{ $commande->tva }}%)</span>
                    <span>{{ number_format($commande->montant_ttc - $commande->montant_ht,2,',',' ') }} MAD</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:15px">
                    <span style="font-weight:700">Total TTC</span>
                    <span style="font-weight:800;color:var(--vert);font-size:16px">{{ number_format($commande->montant_ttc,2,',',' ') }} MAD</span>
                </div>
            </div>
        </div>

        {{-- INFOS --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informations</div>
            </div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Numéro</span>
                    <span style="font-weight:600;color:var(--bleu)">{{ $commande->numero }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Statut</span>
                    <span class="badge badge-{{ $commande->statut }}">{{ ucfirst(str_replace('_',' ',$commande->statut)) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Créé le</span>
                    <span>{{ $commande->created_at->format('d/m/Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Créé par</span>
                    <span style="font-weight:500">{{ $commande->createdBy->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection