@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb') Tableau de bord @endsection

@push('styles')
<style>
    /* --- Styles Spécifiques au Dashboard --- */
    
    /* Bannière Bienvenue */
    .welcome-banner {
        background: linear-gradient(135deg, #0A3D62 0%, #063049 100%);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }
    .welcome-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 1;
        gap: 20px; /* Espace entre le texte et la carte de rôle */
    }
    .role-card {
        background: rgba(241,151,65,0.15);
        border: 1px solid rgba(241,151,65,0.3);
        border-radius: 12px;
        padding: 12px 20px;
        text-align: center;
        min-width: 100px;
    }

    /* Grille pour les listes récentes (Demandes & Commandes) */
    .recent-lists-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    /* --- MEDIA QUERIES --- */
    @media (max-width: 992px) {
        /* Sur tablette, on empile les Demandes et Commandes récentes */
        .recent-lists-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        /* Sur mobile, on ajuste la bannière de bienvenue */
        .welcome-banner {
            padding: 20px 16px; /* Moins de padding sur les côtés */
        }
        .welcome-content {
            flex-direction: column; /* On met la carte de rôle sous le texte */
            align-items: flex-start;
        }
        .welcome-content > div:first-child {
            /* Le texte principal de bienvenue */
            font-size: 18px !important;
        }
        .role-card {
            align-self: flex-start; /* Aligne la carte à gauche au lieu du centre */
            padding: 8px 16px; /* Plus petit sur mobile */
        }
        
        /* Assure que la colonne d'actions des tableaux garde une largeur minimale */
        .actions-wrap {
            min-width: 80px;
        }
    }
</style>
@endpush

@section('content')

{{-- BANNIÈRE BIENVENUE --}}
<div class="welcome-banner">
    <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:rgba(241,151,65,0.1);pointer-events:none"></div>
    <div style="position:absolute;bottom:-40px;left:300px;width:160px;height:160px;border-radius:50%;background:rgba(83,187,90,0.08);pointer-events:none"></div>
    <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#F19741,#53BB5A,#2D9BD6)"></div>
    <div class="welcome-content">
        <div>
            <div style="font-family:'Outfit',sans-serif;font-size:22px;font-weight:800;color:white;margin-bottom:6px">
                Bonjour, {{ auth()->user()->name }} 👋
            </div>
            <div style="font-size:13px;color:rgba(255,255,255,0.5)">
                {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }} — Bienvenue sur votre tableau de bord SGAF
            </div>
        </div>
        <div class="role-card">
            <div style="font-family:'Outfit',sans-serif;font-size:18px;font-weight:800;color:#F19741">
                {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'Utilisateur') }}
            </div>
            <div style="font-size:9px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:1.5px;margin-top:3px">Rôle</div>
        </div>
    </div>
</div>

{{-- STATS CARDS (Déjà gérées par app.blade.php) --}}
<div class="stats-grid" style="margin-bottom:24px">

    <div class="stat-card" style="border-top:3px solid #2D9BD6;border-radius:14px">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['fournisseurs'] }}</div>
            <div class="stat-label">Fournisseurs actifs</div>
            <div style="font-size:11px;color:#53BB5A;font-weight:600;margin-top:4px">↑ +3 ce mois</div>
        </div>
    </div>

    <div class="stat-card" style="border-top:3px solid #F19741;border-radius:14px">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['da_en_attente'] }}</div>
            <div class="stat-label">Demandes en attente</div>
            <div style="font-size:11px;color:var(--gris);font-weight:600;margin-top:4px">{{ $stats['da_total'] }} total</div>
        </div>
    </div>

    <div class="stat-card" style="border-top:3px solid #53BB5A;border-radius:14px">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['bc_mois'] }}</div>
            <div class="stat-label">Commandes ce mois</div>
            <div style="font-size:11px;color:var(--gris);font-weight:600;margin-top:4px">{{ number_format($stats['montant_mois'],0,',',' ') }} MAD</div>
        </div>
    </div>

    <div class="stat-card" style="border-top:3px solid #F19741;border-radius:14px">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><path d="M12 22V7"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $stats['br_mois'] }}</div>
            <div class="stat-label">Réceptions ce mois</div>
            <div style="font-size:11px;color:#53BB5A;font-weight:600;margin-top:4px">{{ $stats['conformite'] }}% conformes</div>
        </div>
    </div>

</div>

{{-- DEMANDES + COMMANDES (Utilisation de la nouvelle classe) --}}
<div class="recent-lists-grid">

    {{-- Demandes récentes --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid #F19741;padding-left:20px">
            <div>
                <div class="card-title">Demandes récentes</div>
                <div class="card-subtitle">Dernières demandes d'achats soumises</div>
            </div>
            @can('da.voir')
            <a href="{{ route('demandes.index') }}" style="font-size:13px;font-weight:600;color:#2D9BD6;text-decoration:none">Voir tout →</a>
            @endcan
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Objet</th>
                        <th>Demandeur</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieres_demandes as $da)
                    <tr>
                        <td>
                            <code style="background:rgba(45,155,214,0.08);color:#2D9BD6;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600">
                                {{ $da->numero }}
                            </code>
                        </td>
                        <td style="font-size:13px">{{ Str::limit($da->objet, 26) }}</td>
                        <td style="font-size:12px;color:var(--gris)">{{ $da->demandeur->name }}</td>
                        <td><span class="badge badge-{{ $da->statut }}">{{ ucfirst(str_replace('_',' ',$da->statut)) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4">
                        <div style="text-align:center;padding:32px;color:var(--gris)">
                            <svg viewBox="0 0 24 24" style="width:36px;height:36px;stroke:var(--gris);fill:none;stroke-width:1.5;margin:0 auto 10px;display:block;opacity:0.4">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <div style="font-size:13px">Aucune demande</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Commandes récentes --}}
    <div class="card">
        <div class="card-header" style="border-left:4px solid #53BB5A;padding-left:20px">
            <div>
                <div class="card-title">Commandes récentes</div>
                <div class="card-subtitle">Derniers bons de commande émis</div>
            </div>
            @can('bc.voir')
            <a href="{{ route('commandes.index') }}" style="font-size:13px;font-weight:600;color:#2D9BD6;text-decoration:none">Voir tout →</a>
            @endcan
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Fournisseur</th>
                        <th>Montant TTC</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dernieres_commandes as $bc)
                    <tr>
                        <td>
                            <code style="background:rgba(83,187,90,0.08);color:#3A9E41;padding:3px 8px;border-radius:5px;font-size:12px;font-weight:600">
                                {{ $bc->numero }}
                            </code>
                        </td>
                        <td style="font-size:13px">{{ Str::limit($bc->fournisseur->raison_sociale, 20) }}</td>
                        <td style="font-weight:700;font-size:13px">
                            {{ number_format($bc->montant_ttc, 2, ',', ' ') }}
                            <span style="font-size:10px;color:var(--gris);font-weight:400">MAD</span>
                        </td>
                        <td><span class="badge badge-{{ $bc->statut }}">{{ ucfirst(str_replace('_',' ',$bc->statut)) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4">
                        <div style="text-align:center;padding:32px;color:var(--gris)">
                            <svg viewBox="0 0 24 24" style="width:36px;height:36px;stroke:var(--gris);fill:none;stroke-width:1.5;margin:0 auto 10px;display:block;opacity:0.4">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                                <line x1="3" y1="6" x2="21" y2="6"/>
                            </svg>
                            <div style="font-size:13px">Aucune commande</div>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- TOP FOURNISSEURS --}}
<div class="card">
    <div class="card-header" style="border-left:4px solid #2D9BD6;padding-left:20px">
        <div>
            <div class="card-title">Top Fournisseurs</div>
            <div class="card-subtitle">Par volume de commandes ce trimestre</div>
        </div>
        @can('fournisseurs.voir')
        <a href="{{ route('fournisseurs.index') }}" style="font-size:13px;font-weight:600;color:#2D9BD6;text-decoration:none">Voir tous →</a>
        @endcan
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fournisseur</th>
                    <th>Secteur</th>
                    <th>Nb Commandes</th>
                    <th>Montant Total</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($top_fournisseurs as $i => $f)
                <tr>
                    <td>
                        @if($i == 0)
                            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#F19741,#D4792A);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;color:white">1</span>
                        @elseif($i == 1)
                            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#8FA3B8,#607D8B);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;color:white">2</span>
                        @elseif($i == 2)
                            <span style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#53BB5A,#3A9E41);display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;color:white">3</span>
                        @else
                            <span style="width:28px;height:28px;border-radius:8px;background:rgba(45,155,214,0.08);display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;color:#2D9BD6">{{ $i+1 }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#2D9BD6,#53BB5A);display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($f->raison_sociale, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;font-size:13px">{{ Str::limit($f->raison_sociale, 24) }}</div>
                                <div style="font-size:10px;color:var(--gris)">{{ $f->code_fournisseur }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12px;color:var(--gris)">{{ $f->secteur_activite ?? '—' }}</td>
                    <td>
                        <span style="background:rgba(45,155,214,0.08);color:#2D9BD6;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700">
                            {{ $f->bons_commande_count ?? 0 }}
                        </span>
                    </td>
                    <td style="font-weight:700;font-size:13px">
                        {{ number_format($f->montant_total ?? 0, 2, ',', ' ') }}
                        <span style="font-size:10px;color:var(--gris);font-weight:400">MAD</span>
                    </td>
                    <td><span class="badge badge-{{ $f->statut }}">{{ ucfirst($f->statut) }}</span></td>
                    <td>
                        <div class="actions-wrap">
                            <a href="{{ route('fournisseurs.show', $f) }}" class="action-btn action-view">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @can('fournisseurs.modifier')
                            <a href="{{ route('fournisseurs.edit', $f) }}" class="action-btn action-edit">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        </div>
                        <h4>Aucun fournisseur</h4>
                        <p>Commencez par ajouter vos premiers fournisseurs</p>
                        @can('fournisseurs.creer')
                        <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Ajouter un fournisseur
                        </a>
                        @endcan
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection