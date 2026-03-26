@extends('layouts.app')
@section('title', 'Détail Audit')
@section('page-title', 'Détail Journal d\'Audit')
@section('breadcrumb') <a href="{{ route('audit.index') }}">Audit</a> <span>›</span> Détail @endsection

@push('styles')
<style>
    /* CSS spécifique pour la page Détail Audit */
    .audit-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 24px;
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        /* On empile les infos sur mobile */
        .audit-info-grid {
            grid-template-columns: 1fr;
            padding: 16px;
            gap: 16px;
            margin-bottom: 16px;
        }

        /* On ajuste les espacements des blocs de code sur mobile */
        .values-block {
            padding: 0 16px 16px !important;
        }

        /* Le bouton retour prend toute la largeur */
        .audit-footer .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div style="max-width:800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Action : {{ ucfirst($log->action) }}</div>
                <div class="card-subtitle">{{ $log->created_at->format('d/m/Y à H:i:s') }}</div>
            </div>
        </div>
        
        <div class="audit-info-grid">
            <div>
                <div style="font-size:11px;color:var(--gris);text-transform:uppercase;margin-bottom:4px">Utilisateur</div>
                <div style="font-weight:600">{{ $log->user ? $log->user->name : 'Système' }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:var(--gris);text-transform:uppercase;margin-bottom:4px">Objet modifié</div>
                <div>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:var(--gris);text-transform:uppercase;margin-bottom:4px">Adresse IP</div>
                <div>{{ $log->ip_address }}</div>
            </div>
        </div>

        @if($log->old_values)
        <div class="values-block" style="padding:0 24px 20px">
            <div style="font-size:13px;font-weight:600;margin-bottom:8px;color:var(--texte)">Valeurs avant modification</div>
            <div style="background:#FFF5F5;border:1px solid rgba(229,62,62,0.2);border-radius:8px;padding:16px;font-size:12px;font-family:monospace;overflow-x:auto">
                @foreach($log->old_values as $key => $value)
                <div style="margin-bottom:4px"><span style="color:#C62828;font-weight:600">{{ $key }}</span> : {{ is_array($value) ? json_encode($value) : $value }}</div>
                @endforeach
            </div>
        </div>
        @endif

        @if($log->new_values)
        <div class="values-block" style="padding:0 24px 24px">
            <div style="font-size:13px;font-weight:600;margin-bottom:8px;color:var(--texte)">Valeurs après modification</div>
            <div style="background:#F0FFF4;border:1px solid rgba(0,169,157,0.2);border-radius:8px;padding:16px;font-size:12px;font-family:monospace;overflow-x:auto">
                @foreach($log->new_values as $key => $value)
                <div style="margin-bottom:4px"><span style="color:#00695C;font-weight:600">{{ $key }}</span> : {{ is_array($value) ? json_encode($value) : $value }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="audit-footer" style="padding:16px 24px;border-top:1px solid #F0F4F9">
            <a href="{{ route('audit.index') }}" class="btn btn-outline">← Retour au journal</a>
        </div>
    </div>
</div>
@endsection