<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('fournisseurs', function (Blueprint $table) {
        $table->id();
        $table->string('code_fournisseur')->unique(); // F-0001
        $table->string('raison_sociale');
        $table->string('forme_juridique')->nullable();
        $table->string('numero_registre')->nullable();
        $table->string('adresse')->nullable();
        $table->string('ville')->nullable();
        $table->string('pays')->default('Maroc');
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->string('site_web')->nullable();
        $table->string('contact_nom')->nullable();
        $table->string('contact_prenom')->nullable();
        $table->string('rib')->nullable();
        $table->string('iban')->nullable();
        $table->string('banque')->nullable();
        $table->integer('delai_paiement')->default(30); // en jours
        $table->string('devise')->default('MAD');
        $table->string('secteur_activite')->nullable();
        $table->string('famille_produits')->nullable();
        $table->enum('statut', ['actif', 'inactif', 'suspendu', 'en_qualification'])->default('actif');
        $table->boolean('is_deleted')->default(false); // soft delete logique
        $table->foreignId('created_by')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
};
