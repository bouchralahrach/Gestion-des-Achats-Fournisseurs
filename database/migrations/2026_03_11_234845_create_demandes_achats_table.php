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
    Schema::create('demandes_achats', function (Blueprint $table) {
        $table->id();
        $table->string('numero')->unique(); // DA-2026-00001
        $table->string('objet');
        $table->text('description')->nullable();
        $table->decimal('quantite', 10, 2);
        $table->string('unite_mesure')->default('unité');
        $table->decimal('budget_estimatif', 15, 2)->nullable();
        $table->string('categorie')->nullable();
        $table->string('centre_cout')->nullable();
        $table->date('date_souhaitee')->nullable();
        $table->enum('statut', ['brouillon','soumise','en_validation','approuvee','rejetee','annulee'])->default('brouillon');
        $table->text('motif_rejet')->nullable();
        $table->foreignId('demandeur_id')->constrained('users');
        $table->foreignId('validateur_id')->nullable()->constrained('users');
        $table->timestamp('date_validation')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes_achats');
    }
};
