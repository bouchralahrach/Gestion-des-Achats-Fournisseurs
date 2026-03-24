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
    Schema::create('bons_commande', function (Blueprint $table) {
        $table->id();
        $table->string('numero')->unique(); // BC-2026-00001
        $table->foreignId('fournisseur_id')->constrained('fournisseurs');
        $table->foreignId('demande_achat_id')->nullable()->constrained('demandes_achats');
        $table->decimal('montant_ht', 15, 2)->default(0);
        $table->decimal('tva', 5, 2)->default(20);
        $table->decimal('montant_ttc', 15, 2)->default(0);
        $table->string('conditions_livraison')->nullable();
        $table->date('date_livraison_prevue')->nullable();
        $table->string('lieu_livraison')->nullable();
        $table->string('mode_paiement')->nullable();
        $table->enum('statut', ['en_attente','envoyee','confirmee','en_livraison','soldee','annulee'])->default('en_attente');
        $table->foreignId('created_by')->constrained('users');
        $table->timestamp('date_envoi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bons_commande');
    }
};
