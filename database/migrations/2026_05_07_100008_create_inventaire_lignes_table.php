<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaire_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventaire_id')->constrained('inventaires')->onDelete('cascade');
            
            // ✅ CORRECTION : Utiliser unsignedBigInteger explicite
            $table->unsignedBigInteger('piece_id');
            $table->foreign('piece_id')->references('id')->on('pieces_conviction')->onDelete('cascade');
            
            $table->enum('statut', ['presente', 'manquante', 'endommagee', 'deplacee']);
            
            // ✅ CORRECTION : Même chose pour emplacement
            $table->unsignedBigInteger('emplacement_constate_id')->nullable();
            $table->foreign('emplacement_constate_id')->references('id')->on('emplacements')->nullOnDelete();
            
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaire_lignes');
    }
};