<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suivi_commandes', function (Blueprint $table) {
            $table->id();
            $table->date('date_demande')->nullable();
            $table->string('nature');
            $table->string('numero')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('livraison')->nullable();
            $table->string('type')->default("Commande d'achat");
            $table->string('feuille')->default('Feuil1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suivi_commandes');
    }
};