<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandeAchatController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\BonCommandeController;
use App\Http\Controllers\BonReceptionController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuiviCommandeController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // Suivi commandes
    Route::get('/suivi', [SuiviCommandeController::class, 'index'])->name('suivi.index');

    // Demandes d'achat
    Route::get('/demandes', [DemandeAchatController::class, 'index'])->name('demandes.index');
    Route::get('/demandes/create', [DemandeAchatController::class, 'create'])->name('demandes.create');
    Route::post('/demandes', [DemandeAchatController::class, 'store'])->name('demandes.store');
    Route::get('/demandes/{demande}', [DemandeAchatController::class, 'show'])->name('demandes.show');
    Route::get('/demandes/{demande}/edit', [DemandeAchatController::class, 'edit'])->name('demandes.edit');
    Route::put('/demandes/{demande}', [DemandeAchatController::class, 'update'])->name('demandes.update');
    Route::delete('/demandes/{demande}', [DemandeAchatController::class, 'destroy'])->name('demandes.destroy');
    Route::match(['post', 'patch'], '/demandes/{demande}/soumettre', [DemandeAchatController::class, 'soumettre'])->name('demandes.soumettre');
    Route::post('/demandes/{demande}/approuver', [DemandeAchatController::class, 'approuver'])->name('demandes.approuver');
    Route::post('/demandes/{demande}/rejeter', [DemandeAchatController::class, 'rejeter'])->name('demandes.rejeter');
    Route::post('/demandes/{demande}/annuler', [DemandeAchatController::class, 'annuler'])->name('demandes.annuler');

    // Fournisseurs
    Route::get('/fournisseurs', [FournisseurController::class, 'index'])->name('fournisseurs.index');
    Route::get('/fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
    Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('fournisseurs.store');
    Route::get('/fournisseurs/{fournisseur}', [FournisseurController::class, 'show'])->name('fournisseurs.show');
    Route::get('/fournisseurs/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
    Route::put('/fournisseurs/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
    Route::delete('/fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');
    Route::post('/fournisseurs/{fournisseur}/restore', [FournisseurController::class, 'restore'])->name('fournisseurs.restore');
    Route::get('/fournisseurs/export/pdf', [FournisseurController::class, 'exportPdf'])->name('fournisseurs.exportPdf');
    Route::get('/fournisseurs/export/excel', [FournisseurController::class, 'exportExcel'])->name('fournisseurs.exportExcel');

    // Bons de commande
    Route::get('/commandes', [BonCommandeController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/create', [BonCommandeController::class, 'create'])->name('commandes.create');
    Route::post('/commandes', [BonCommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{commande}', [BonCommandeController::class, 'show'])->name('commandes.show');
    Route::get('/commandes/{commande}/edit', [BonCommandeController::class, 'edit'])->name('commandes.edit');
    Route::put('/commandes/{commande}', [BonCommandeController::class, 'update'])->name('commandes.update');
    Route::post('/commandes/{commande}/valider', [BonCommandeController::class, 'valider'])->name('commandes.valider');
    Route::post('/commandes/{commande}/envoyer', [BonCommandeController::class, 'envoyer'])->name('commandes.envoyer');
    Route::post('/commandes/{commande}/annuler', [BonCommandeController::class, 'annuler'])->name('commandes.annuler');
    Route::delete('/commandes/{commande}', [BonCommandeController::class, 'destroy'])->name('commandes.destroy');
    Route::get('/commandes/{commande}/pdf', [BonCommandeController::class, 'exportPdf'])->name('commandes.exportPdf');

    // Bons de réception
    Route::get('/receptions', [BonReceptionController::class, 'index'])->name('receptions.index');
    Route::get('/receptions/create', [BonReceptionController::class, 'create'])->name('receptions.create');
    Route::post('/receptions', [BonReceptionController::class, 'store'])->name('receptions.store');
    Route::get('/receptions/{reception}', [BonReceptionController::class, 'show'])->name('receptions.show');
    Route::get('/receptions/{reception}/edit', [BonReceptionController::class, 'edit'])->name('receptions.edit');
    Route::put('/receptions/{reception}', [BonReceptionController::class, 'update'])->name('receptions.update');

    // Statistiques
    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    Route::get('/statistiques/export/pdf', [StatistiqueController::class, 'exportPdf'])->name('statistiques.exportPdf');

    // Audit
    Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('/audit/{log}', [AuditController::class, 'show'])->name('audit.show');

    // Utilisateurs
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
});