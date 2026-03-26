@extends('layouts.app')
@section('title', 'Statistiques')
@section('page-title', 'Statistiques & Tableaux de bord')
@section('breadcrumb') Statistiques @endsection

@section('content')

{{-- STATS --}}
<div class="stats-grid" style="margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['total_fournisseurs'] }}</div>
            <div class="stat-label">Fournisseurs actifs</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg view@extends('layouts.app')
@section('title', 'Statistiques')
@section('page-title', 'Statistiques & Tableaux de bord')
@section('breadcrumb') Statistiques @endsection

@push('styles')
<style>
    /* --- Grille pour DA et Top Fournisseurs --- */
    .stats-layout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* --- Conteneur pour le graphique en barres --- */
    .chart-container {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        height: 180px;
        /* Permet de scroller horizontalement si les barres sont trop serrées sur mobile */
        overflow-x: auto; 
        padding-bottom: 10px; /* Espace pour la barre de scroll */
    }
    
    .chart-bar-wrap {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        min-width: 30px; /* Largeur minimale d'une barre pour rester lisible */
    }

    /* --- MEDIA QUERIES --- */
    @media (max-width: 992px) {
        /* Sur tablette et mobile, on empile les cartes Demandes et Top Fournisseurs */
        .stats-layout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

{{-- STATS (Déjà gérées par app.blade.php) --}}
<div class="stats-grid" style="margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['total_fournisseurs'] }}</div>
            <div class="stat-label">Fournisseurs actifs</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['total_commandes'] }}</div>
            <div class="stat-label">Total commandes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['montant_total'],0,',',' ') }}</div>
            <div class="stat-label">Montant total (MAD)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['taux_conformite'] }}%</div>
            <div class="stat-label">Taux de conformité</div>
        </div>
    </div>
</div>

{{-- DA + TOP FOURNISSEURS --}}
<div class="stats-layout-grid">

    {{-- DA par statut --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
            <div class="card-title">Demandes par statut</div>
        </div>
        <div style="padding:24px;display:flex;flex-direction:column;gap:14px">
            @forelse($daParStatut as $da)
            @php
                $total = $daParStatut->sum('total');
                $pct = $total > 0 ? round(($da->total / $total) * 100) : 0;
                $colors = [
                    'brouillon' => '#8FA3B8',
                    'soumise'   => '#2D9BD6',
                    'approuvee' => '#53BB5A',
                    'rejetee'   => '#E53E3E',
                    'annulee'   => '#CBD5E0',
                ];
                $color = $colors[$da->statut] ?? '#CBD5E0';
            @endphp
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                    <span style="font-size:13px;font-weight:500;color:var(--texte)">
                        {{ ucfirst(str_replace('_',' ',$da->statut)) }}
                    </span>
                    <span style="font-size:13px;font-weight:700;color:var(--texte)">
                        {{ $da->total }}
                        <span style="font-size:11px;color:var(--gris);font-weight:400">({{ $pct }}%)</span>
                    </span>
                </div>
                <div style="background:#EDF2F7;border-radius:20px;height:8px;overflow:hidden">
                    <div style="background:{{ $color }};height:100%;width:{{ $pct }}%;border-radius:20px;transition:width 0.6s ease"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:var(--gris);font-size:13px">
                Aucune demande enregistrée
            </div>
            @endforelse
        </div>
    </div>

    {{-- Top 5 Fournisseurs --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid var(--bleu);padding-left:20px">
            <div class="card-title">Top 5 Fournisseurs</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fournisseur</th>
                        <th>Commandes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topFournisseurs as $i => $f)
                    <tr>
                        <td>
                            @if($i == 0)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#F19741,#D4792A);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">1</span>
                            @elseif($i == 1)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#8FA3B8,#607D8B);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">2</span>
                            @elseif($i == 2)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#53BB5A,#3A9E41);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">3</span>
                            @else
                                <span style="font-weight:700;color:var(--gris)">{{ $i+1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($f->raison_sociale,0,2)) }}
                                </div>
                                <span style="font-size:13px;font-weight:500">{{ Str::limit($f->raison_sociale,22) }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="background:rgba(45,155,214,0.08);color:var(--bleu);padding:3px 10px;border-radius:6px;font-size:12px;font-weight:700">
                                {{ $f->bons_commande_count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3">
                        <div style="text-align:center;padding:24px;color:var(--gris);font-size:13px">
                            Aucun fournisseur
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Commandes par mois --}}
<div class="card">
    <div class="card-header" style="border-left:4px solid var(--vert);padding-left:20px">
        <div class="card-title">Commandes par mois — {{ date('Y') }}</div>
    </div>
    <div style="padding:28px">
        @if($commandesParMois->count() > 0)
        <div class="chart-container">
            @php $maxMontant = $commandesParMois->max('montant') ?: 1; @endphp
            @foreach($commandesParMois as $mois)
            @php
                $hauteur = max(round(($mois->montant / $maxMontant) * 100), 4);
                $nomsMois = ['','Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
            @endphp
            <div class="chart-bar-wrap">
                <div style="font-size:10px;color:var(--texte);font-weight:700">{{ $mois->total }}</div>
                <div style="width:100%;background:linear-gradient(180deg,var(--bleu),var(--vert));border-radius:6px 6px 0 0;height:{{ $hauteur }}%;min-height:6px;transition:height 0.6s ease;position:relative" title="{{ number_format($mois->montant,0,',',' ') }} MAD"></div>
                <div style="font-size:10px;color:var(--gris);font-weight:500">{{ $nomsMois[$mois->mois] }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:40px;color:var(--gris)">
            <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:var(--gris);fill:none;stroke-width:1.5;margin:0 auto 12px;display:block;opacity:0.4">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <div style="font-size:13px">Aucune commande cette année</div>
        </div>
        @endif
    </div>
</div>

@endsectionBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['total_commandes'] }}</div>
            <div class="stat-label">Total commandes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ number_format($stats['montant_total'],0,',',' ') }}</div>
            <div class="stat-label">Montant total (MAD)</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['taux_conformite'] }}%</div>
            <div class="stat-label">Taux de conformité</div>
        </div>
    </div>
</div>

{{-- DA + TOP FOURNISSEURS --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    {{-- DA par statut --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
            <div class="card-title">Demandes par statut</div>
        </div>
        <div style="padding:24px;display:flex;flex-direction:column;gap:14px">
            @forelse($daParStatut as $da)
            @php
                $total = $daParStatut->sum('total');
                $pct = $total > 0 ? round(($da->total / $total) * 100) : 0;
                $colors = [
                    'brouillon' => '#8FA3B8',
                    'soumise'   => '#2D9BD6',
                    'approuvee' => '#53BB5A',
                    'rejetee'   => '#E53E3E',
                    'annulee'   => '#CBD5E0',
                ];
                $color = $colors[$da->statut] ?? '#CBD5E0';
            @endphp
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px">
                    <span style="font-size:13px;font-weight:500;color:var(--texte)">
                        {{ ucfirst(str_replace('_',' ',$da->statut)) }}
                    </span>
                    <span style="font-size:13px;font-weight:700;color:var(--texte)">
                        {{ $da->total }}
                        <span style="font-size:11px;color:var(--gris);font-weight:400">({{ $pct }}%)</span>
                    </span>
                </div>
                <div style="background:#EDF2F7;border-radius:20px;height:8px;overflow:hidden">
                    <div style="background:{{ $color }};height:100%;width:{{ $pct }}%;border-radius:20px;transition:width 0.6s ease"></div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:var(--gris);font-size:13px">
                Aucune demande enregistrée
            </div>
            @endforelse
        </div>
    </div>

    {{-- Top 5 Fournisseurs --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid var(--bleu);padding-left:20px">
            <div class="card-title">Top 5 Fournisseurs</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fournisseur</th>
                        <th>Commandes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topFournisseurs as $i => $f)
                    <tr>
                        <td>
                            @if($i == 0)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#F19741,#D4792A);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">1</span>
                            @elseif($i == 1)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#8FA3B8,#607D8B);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">2</span>
                            @elseif($i == 2)
                                <span style="width:24px;height:24px;border-radius:6px;background:linear-gradient(135deg,#53BB5A,#3A9E41);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;color:white">3</span>
                            @else
                                <span style="font-weight:700;color:var(--gris)">{{ $i+1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($f->raison_sociale,0,2)) }}
                                </div>
                                <span style="font-size:13px;font-weight:500">{{ Str::limit($f->raison_sociale,22) }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="background:rgba(45,155,214,0.08);color:var(--bleu);padding:3px 10px;border-radius:6px;font-size:12px;font-weight:700">
                                {{ $f->bons_commande_count }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3">
                        <div style="text-align:center;padding:24px;color:var(--gris);font-size:13px">
                            Aucun fournisseur
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Commandes par mois --}}
<div class="card">
    <div class="card-header" style="border-left:4px solid var(--vert);padding-left:20px">
        <div class="card-title">Commandes par mois — {{ date('Y') }}</div>
    </div>
    <div style="padding:28px">
        @if($commandesParMois->count() > 0)
        <div style="display:flex;align-items:flex-end;gap:10px;height:180px">
            @php $maxMontant = $commandesParMois->max('montant') ?: 1; @endphp
            @foreach($commandesParMois as $mois)
            @php
                $hauteur = max(round(($mois->montant / $maxMontant) * 100), 4);
                $nomsMois = ['','Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
            @endphp
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px">
                <div style="font-size:10px;color:var(--texte);font-weight:700">{{ $mois->total }}</div>
                <div style="width:100%;background:linear-gradient(180deg,var(--bleu),var(--vert));border-radius:6px 6px 0 0;height:{{ $hauteur }}%;min-height:6px;transition:height 0.6s ease;position:relative" title="{{ number_format($mois->montant,0,',',' ') }} MAD"></div>
                <div style="font-size:10px;color:var(--gris);font-weight:500">{{ $nomsMois[$mois->mois] }}</div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align:center;padding:40px;color:var(--gris)">
            <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:var(--gris);fill:none;stroke-width:1.5;margin:0 auto 12px;display:block;opacity:0.4">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <div style="font-size:13px">Aucune commande cette année</div>
        </div>
        @endif
    </div>
</div>

@endsection