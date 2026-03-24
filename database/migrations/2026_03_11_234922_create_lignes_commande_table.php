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
    Schema::create('lignes_commande', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bon_commande_id')->constrained('bons_commande')->onDelete('cascade');
        $table->string('designation');
        $table->decimal('quantite', 10, 2);
        $table->string('unite')->default('unité');
        $table->decimal('prix_unitaire', 15, 2);
        $table->decimal('remise', 5, 2)->default(0);
        $table->decimal('tva', 5, 2)->default(20);
        $table->decimal('montant_total', 15, 2);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lignes_commande');
    }
};
