@extends('layouts.app')
@section('title', 'Suivi des Commandes')
@section('page-title', 'Suivi des Commandes & Demandes')
@section('breadcrumb') Suivi Commandes @endsection

@push('styles')
<style>
    /* CSS spécifique pour améliorer l'affichage sur mobile de la page Suivi */
    @media (max-width: 768px) {
        .filters-bar form {
            flex-direction: column;
            width: 100%;
        }
        .filter-wrap, .filter-select, .btn-sm {
            width: 100%;
        }
        
        /* Ajustement de la pagination personnalisée pour mobile */
        .custom-pagination {
            flex-direction: column;
            justify-content: center !important;
            text-align: center;
            gap: 16px !important;
        }
        
        /* Ajustement du conteneur des pages pour qu'il s'adapte s'il y a beaucoup de pages */
        .custom-pagination > div:last-child {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')

{{-- STATS --}}
<div class="stats-grid" style="margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-label">Total entrées</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $livrees }}</div>
            <div class="stat-label">Livrées</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $enCours }}</div>
            <div class="stat-label">En cours</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $fournisseurs }}</div>
            <div class="stat-label">Fournisseurs</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Suivi des Demandes et Commandes d'Achats</div>
            <div class="card-subtitle">Période : 01/10/2024 — 15/09/2025</div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <span style="background:rgba(0,102,179,0.08);color:var(--bleu-clair);padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600">
                📋 Feuil1 : {{ $countFeuil1 }} lignes
            </span>
            <span style="background:rgba(0,169,157,0.08);color:var(--vert);padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600">
                📋 DA Namaa : {{ $countNamea }} lignes
            </span>
        </div>
    </div>

    {{-- FILTRES --}}
    <div class="filters-bar">
        <form method="GET" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;align-items:center">
            <div class="filter-wrap" style="min-width:220px">
                <span class="filter-search-icon">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search" class="filter-input"
                       placeholder="Nature, N°, Fournisseur..."
                       value="{{ request('search') }}">
            </div>
            <select name="feuille" class="filter-select">
                <option value="">Toutes les feuilles</option>
                <option value="Feuil1"   {{ request('feuille')=='Feuil1'  ?'selected':'' }}>Feuil1</option>
                <option value="DA Namaa" {{ request('feuille')=='DA Namaa'?'selected':'' }}>DA Namaa</option>
            </select>
            <select name="type" class="filter-select">
                <option value="">Tous les types</option>
                <option value="Commande d'achat" {{ request('type')=="Commande d'achat"?'selected':'' }}>Commande d'achat</option>
                <option value="Demande d'achat"  {{ request('type')=="Demande d'achat" ?'selected':'' }}>Demande d'achat</option>
            </select>
            <select name="livraison" class="filter-select">
                <option value="">Toutes livraisons</option>
                <option value="ok"       {{ request('livraison')=='ok'      ?'selected':'' }}>✅ Livrée</option>
                <option value="en_cours" {{ request('livraison')=='en_cours'?'selected':'' }}>⏳ En cours</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                Filtrer
            </button>
            <a href="{{ route('suivi.index') }}" class="btn btn-outline btn-sm" style="text-align: center;">Reset</a>
        </form>
    </div>

    {{-- TABLEAU --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:110px">Date</th>
                    <th>Nature de la demande</th>
                    <th style="width:140px">N° Demande</th>
                    <th style="width:200px">Fournisseur</th>
                    <th style="width:120px">Livraison</th>
                    <th style="width:80px">Type</th>
                    <th style="width:100px">Feuille</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suivi as $row)
                <tr>
                    <td style="white-space:nowrap;color:var(--gris);font-size:12px">
                        {{ $row->date_demande ? \Carbon\Carbon::parse($row->date_demande)->format('d/m/Y') : '—' }}
                    </td>
                    <td>
                        <span style="font-size:13px;line-height:1.5" title="{{ $row->nature }}">
                            {{ Str::limit($row->nature, 60) }}
                        </span>
                    </td>
                    <td>
                        <code style="background:rgba(0,102,179,0.06);color:var(--bleu-clair);padding:3px 8px;border-radius:6px;font-size:12px;font-weight:600">
                            {{ $row->numero ?? '—' }}
                        </code>
                    </td>
                    <td style="font-size:13px">
                        @if($row->fournisseur)
                            <div style="display:flex;align-items:center;gap:8px">
                                <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--bleu-clair),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:10px;font-weight:700;flex-shrink:0">
                                    {{ strtoupper(substr($row->fournisseur, 0, 1)) }}
                                </div>
                                <span>{{ Str::limit($row->fournisseur, 22) }}</span>
                            </div>
                        @else
                            <span style="color:var(--gris);font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        @php $liv = strtolower($row->livraison ?? ''); @endphp
                        @if($liv === 'ok')
                            <span class="badge badge-approuvee">✓ Livrée</span>
                        @elseif(str_contains($liv, 'cours'))
                            <span class="badge badge-en_attente">⏳ En cours</span>
                        @elseif($row->livraison && strlen($row->livraison) >= 6)
                            <span class="badge badge-soumise" style="font-size:10px">📅 {{ $row->livraison }}</span>
                        @else
                            <span style="color:var(--gris);font-size:12px">—</span>
                        @endif
                    </td>
                    <td>
                        @if($row->type == "Commande d'achat")
                            <span class="badge badge-soumise">BC</span>
                        @else
                            <span class="badge badge-en_attente">DA</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size:11px;color:var(--gris);font-weight:600;background:#F0F4F9;padding:3px 8px;border-radius:5px">
                            {{ $row->feuille }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <h4>Aucun résultat trouvé</h4>
                        <p>Modifiez vos filtres ou réinitialisez la recherche</p>
                        <a href="{{ route('suivi.index') }}" class="btn btn-outline">Réinitialiser</a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION PERSONNALISÉE --}}
    @if($suivi->hasPages())
    <div class="custom-pagination" style="display:flex;align-items:center;justify-content:space-between;padding:16px 24px;border-top:1px solid #F0F4F9;flex-wrap:wrap;gap:12px">
        <div style="font-size:12px;color:var(--gris)">
            Affichage <strong>{{ $suivi->firstItem() }}</strong> – <strong>{{ $suivi->lastItem() }}</strong> sur <strong>{{ $suivi->total() }}</strong> résultats
        </div>
        <div style="display:flex;gap:4px;align-items:center">
            {{-- Previous --}}
            @if($suivi->onFirstPage())
                <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid #E0EAF4;background:#F0F4F9;color:var(--gris);font-size:14px">‹</span>
            @else
                <a href="{{ $suivi->previousPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid #E0EAF4;background:white;color:var(--texte);text-decoration:none;font-size:14px;transition:all 0.15s">‹</a>
            @endif

            {{-- Pages --}}
            @foreach($suivi->getUrlRange(1, $suivi->lastPage()) as $page => $url)
                @if($page == $suivi->currentPage())
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid var(--bleu-clair);background:var(--bleu-clair);color:white;font-size:13px;font-weight:700">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid #E0EAF4;background:white;color:var(--texte);text-decoration:none;font-size:13px;transition:all 0.15s">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($suivi->hasMorePages())
                <a href="{{ $suivi->nextPageUrl() }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid #E0EAF4;background:white;color:var(--texte);text-decoration:none;font-size:14px;transition:all 0.15s">›</a>
            @else
                <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;border:1.5px solid #E0EAF4;background:#F0F4F9;color:var(--gris);font-size:14px">›</span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection