@extends('layouts.app')
@section('title', 'Modifier ' . $reception->numero)
@section('page-title', 'Modifier Réception')
@section('breadcrumb') 
<a href="{{ route('receptions.index') }}" class="text-gray-500 hover:text-blue-600 transition-colors">Réceptions</a> 
<span class="mx-2 text-gray-300">›</span> 
<span class="text-gray-500">{{ $reception->numero }}</span>
<span class="mx-2 text-gray-300">›</span> 
<span class="font-semibold text-blue-600">Edition</span>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="form-section shadow-2xl border-0 overflow-visible">
        <div class="form-section-header bg-gray-50/80 px-10 py-6 rounded-t-2xl flex items-center justify-between">
            <h3 class="form-section-title text-base">
                <div class="bg-blue-600 p-2 rounded-xl text-white shadow-lg shadow-blue-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                Modification du Bon de Réception
            </h3>
            <span class="px-4 py-1.5 bg-blue-50 text-blue-700 text-xs font-black rounded-full border border-blue-100 shadow-sm uppercase tracking-widest">{{ $reception->numero }}</span>
        </div>
        
        <form method="POST" action="{{ route('receptions.update', $reception) }}" class="p-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                <!-- Date de Réception -->
                <div class="form-group-custom">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Date de Réception <span class="text-red-500">*</span></label>
                    <input type="date" name="date_reception" id="date_reception" class="form-input-custom w-full py-3.5 bg-gray-50 focus:bg-white transition-all font-medium" value="{{ old('date_reception', $reception->date_reception->format('Y-m-d')) }}" required>
                    @error('date_reception')<p class="text-[10px] text-red-500 font-bold mt-2 px-1">{{ $message }}</p>@enderror
                </div>

                <!-- Numéro de Livraison Fournisseur -->
                <div class="form-group-custom">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">N° Livraison Fournisseur</label>
                    <input type="text" name="numero_livraison_fournisseur" id="numero_livraison_fournisseur" class="form-input-custom w-full py-3.5 bg-gray-50 focus:bg-white transition-all" value="{{ old('numero_livraison_fournisseur', $reception->numero_livraison_fournisseur) }}" placeholder="Ex: BL-2024-001">
                </div>

                <!-- État de la Réception -->
                <div class="form-group-custom md:col-span-2">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">État de la Réception <span class="text-red-500">*</span></label>
                    <select name="etat" id="etat" class="form-input-custom w-full font-black py-3.5 bg-gray-50 focus:bg-white transition-all" required>
                        <option value="conforme" {{ old('etat', $reception->etat) == 'conforme' ? 'selected' : '' }}>✅ Conforme</option>
                        <option value="non_conforme" {{ old('etat', $reception->etat) == 'non_conforme' ? 'selected' : '' }}>❌ Non Conforme</option>
                        <option value="avec_reserves" {{ old('etat', $reception->etat) == 'avec_reserves' ? 'selected' : '' }}>⚠️ Avec Réserves</option>
                    </select>
                    @error('etat')<p class="text-[10px] text-red-500 font-bold mt-2 px-1">{{ $message }}</p>@enderror
                </div>

                <!-- Observations -->
                <div class="form-group-custom md:col-span-2">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-1">Observations & Remarques</label>
                    <textarea name="observations" id="observations" class="form-input-custom w-full min-h-[140px] p-5 bg-gray-50 focus:bg-white transition-all leading-relaxed" rows="4" placeholder="Observations sur la réception...">{{ old('observations', $reception->observations) }}</textarea>
                </div>
            </div>

            <!-- Linked Items (Read Only) -->
            @if($reception->bonCommande && $reception->bonCommande->lignes->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-100">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-6 px-1 text-center">Articles liés au Bon de Commande {{ $reception->bonCommande->numero }}</p>
                <div class="rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <th class="px-6 py-4">Désignation</th>
                                <th class="px-6 py-4 text-center">Quantité</th>
                                <th class="px-6 py-4 text-right">Total HT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($reception->bonCommande->lignes as $ligne)
                            <tr class="text-sm">
                                <td class="px-6 py-4 font-bold text-gray-700">{{ $ligne->designation }}</td>
                                <td class="px-6 py-4 text-center font-medium text-gray-500">{{ number_format($ligne->quantite, 2, ',', ' ') }} {{ $ligne->unite }}</td>
                                <td class="px-6 py-4 text-right font-black text-blue-600">{{ number_format($ligne->montant_total, 2, ',', ' ') }} MAD</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between mt-12 pt-10 border-t border-gray-100">
                <a href="{{ route('receptions.show', $reception) }}" class="btn btn-outline px-8 py-3.5 font-bold text-gray-500 hover:text-gray-800 border-2">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary px-12 py-3.5 shadow-2xl shadow-blue-200 transition-all hover:scale-[1.03] active:scale-95 text-base">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
