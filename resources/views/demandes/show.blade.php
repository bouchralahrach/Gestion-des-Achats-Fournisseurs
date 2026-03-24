@extends('layouts.app')
@section('title', $demande->numero)
@section('page-title', 'Demande ' . $demande->numero)
@section('breadcrumb')
    <a href="{{ route('demandes.index') }}">Demandes</a> <span>›</span> {{ $demande->numero }}
@endsection

@section('content')
<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px">

    {{-- DÉTAILS --}}
    <div>
        <div class="card" style="margin-bottom:20px">
            <div class="card-header" style="border-left:4px solid var(--bleu);padding-left:20px">
                <div>
                    <div class="card-title">{{ $demande->numero }}</div>
                    <div class="card-subtitle">Créée le {{ $demande->created_at->format('d/m/Y à H:i') }}</div>
                </div>
                <span class="badge badge-{{ $demande->statut }}" style="font-size:13px;padding:6px 14px">
                    {{ ucfirst(str_replace('_',' ',$demande->statut)) }}
                </span>
            </div>

            <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Objet</div>
                    <div style="font-weight:600;font-size:14px">{{ $demande->objet }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Demandeur</div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,var(--bleu),var(--vert));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700">
                            {{ strtoupper(substr($demande->demandeur->name,0,1)) }}
                        </div>
                        <span style="font-weight:600">{{ $demande->demandeur->name }} {{ $demande->demandeur->prenom }}</span>
                    </div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Quantité</div>
                    <div style="font-weight:600">{{ $demande->quantite }} {{ $demande->unite_mesure }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Budget estimatif</div>
                    <div style="font-weight:700;color:var(--bleu);font-size:15px">
                        {{ $demande->budget_estimatif ? number_format($demande->budget_estimatif,2,',',' ').' MAD' : '—' }}
                    </div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Catégorie</div>
                    <div>{{ $demande->categorie ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Centre de coût</div>
                    <div>{{ $demande->centre_cout ?? '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Date souhaitée</div>
                    <div>{{ $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : '—' }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Date de création</div>
                    <div>{{ $demande->created_at->format('d/m/Y') }}</div>
                </div>

                @if($demande->description)
                <div style="grid-column:1/-1">
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Description</div>
                    <div style="background:var(--bg);padding:14px;border-radius:8px;font-size:13px;line-height:1.6;border:1px solid #EDF2F7">
                        {{ $demande->description }}
                    </div>
                </div>
                @endif

                @if($demande->motif_rejet)
                <div style="grid-column:1/-1">
                    <div style="font-size:11px;color:#E53E3E;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Motif de rejet</div>
                    <div style="background:rgba(229,62,62,0.06);border:1px solid rgba(229,62,62,0.2);padding:14px;border-radius:8px;font-size:13px;color:#C62828;line-height:1.6">
                        {{ $demande->motif_rejet }}
                    </div>
                </div>
                @endif

                @if($demande->validateur_id && $demande->validateur)
                <div style="grid-column:1/-1;padding-top:16px;border-top:1px solid #EDF2F7">
                    <div style="font-size:11px;color:var(--gris);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">
                        {{ $demande->statut == 'approuvee' ? 'Approuvée par' : 'Traitée par' }}
                    </div>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,var(--orange),var(--orange-dark));display:flex;align-items:center;justify-content:center;color:white;font-size:11px;font-weight:700">
                            {{ strtoupper(substr($demande->validateur->name,0,1)) }}
                        </div>
                        <span style="font-weight:600">{{ $demande->validateur->name }} {{ $demande->validateur->prenom }}</span>
                        @if($demande->date_validation)
                        <span style="font-size:12px;color:var(--gris)">— le {{ \Carbon\Carbon::parse($demande->date_validation)->format('d/m/Y') }}</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="card">
            <div class="card-header" style="border-left:4px solid var(--orange);padding-left:20px">
                <div class="card-title">Actions</div>
            </div>
            <div style="padding:20px;display:flex;flex-direction:column;gap:10px">

                {{-- Soumettre (demandeur, brouillon) --}}
                @if($demande->statut == 'brouillon' && $demande->demandeur_id == auth()->id())
                <form method="POST" action="{{ route('demandes.soumettre', $demande) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Soumettre
                    </button>
                </form>
                <a href="{{ route('demandes.edit', $demande) }}" class="btn btn-outline" style="justify-content:center">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modifier
                </a>
                @endif

                {{-- Approuver / Rejeter (validateur, soumise) --}}
                @can('da.valider')
                @if($demande->statut == 'soumise')
                <form method="POST" action="{{ route('demandes.approuver', $demande) }}">
                    @csrf
                    <button type="submit" class="btn btn-success" style="width:100%;justify-content:center">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Approuver
                    </button>
                </form>

                <div style="background:var(--bg);border-radius:10px;padding:14px;border:1px solid #EDF2F7">
                    <div style="font-size:12px;font-weight:600;color:var(--texte);margin-bottom:8px">Rejeter avec motif :</div>
                    <form method="POST" action="{{ route('demandes.rejeter', $demande) }}">
                        @csrf
                        <textarea name="motif_rejet" class="form-control" placeholder="Motif de rejet obligatoire..." required style="min-height:80px;margin-bottom:8px"></textarea>
                        <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            Rejeter
                        </button>
                    </form>
                </div>
                @endif
                @endcan

                {{-- Annuler --}}
                @if(in_array($demande->statut, ['brouillon','soumise']) && $demande->demandeur_id == auth()->id())
                <form method="POST" action="{{ route('demandes.annuler', $demande) }}"
                      onsubmit="return confirm('Annuler cette demande ?')">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width:100%;justify-content:center;color:#E53E3E;border-color:#E53E3E">
                        Annuler la demande
                    </button>
                </form>
                @endif

                {{-- Statut info --}}
                @if($demande->statut == 'approuvee')
                <div style="background:rgba(83,187,90,0.08);border:1px solid rgba(83,187,90,0.2);border-radius:10px;padding:12px;text-align:center">
                    <div style="color:#2E8B35;font-weight:600;font-size:13px">✓ Demande approuvée</div>
                </div>
                @elseif($demande->statut == 'rejetee')
                <div style="background:rgba(229,62,62,0.08);border:1px solid rgba(229,62,62,0.2);border-radius:10px;padding:12px;text-align:center">
                    <div style="color:#E53E3E;font-weight:600;font-size:13px">✗ Demande rejetée</div>
                </div>
                @elseif($demande->statut == 'annulee')
                <div style="background:rgba(143,163,184,0.1);border:1px solid #EDF2F7;border-radius:10px;padding:12px;text-align:center">
                    <div style="color:var(--gris);font-weight:600;font-size:13px">Demande annulée</div>
                </div>
                @endif

                <a href="{{ route('demandes.index') }}" class="btn btn-outline" style="justify-content:center">
                    ← Retour
                </a>
            </div>
        </div>

        {{-- INFO CARD --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informations</div>
            </div>
            <div style="padding:16px;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Numéro</span>
                    <span style="font-weight:600;color:var(--bleu)">{{ $demande->numero }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Statut</span>
                    <span class="badge badge-{{ $demande->statut }}">{{ ucfirst(str_replace('_',' ',$demande->statut)) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Créée le</span>
                    <span>{{ $demande->created_at->format('d/m/Y') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px">
                    <span style="color:var(--gris)">Modifiée le</span>
                    <span>{{ $demande->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection