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
    Schema::create('bons_reception', function (Blueprint $table) {
        $table->id();
        $table->string('numero')->unique(); // BR-2026-00001
        $table->foreignId('bon_commande_id')->constrained('bons_commande');
        $table->date('date_reception');
        $table->string('numero_livraison_fournisseur')->nullable();
        $table->enum('etat', ['conforme', 'non_conforme', 'avec_reserves'])->default('conforme');
        $table->text('observations')->nullable();
        $table->foreignId('receptionnaire_id')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bons_reception');
    }
};
