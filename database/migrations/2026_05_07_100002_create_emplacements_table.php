<?php
// database/migrations/2026_05_07_100002_create_emplacements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emplacements', function (Blueprint $table) {
            $table->id();
            $table->string('salle'); // Salle A, Salle B
            $table->string('armoire'); // Armoire 1, 2, 3...
            $table->string('etagere')->nullable(); // Haut, Bas, Milieu
            $table->string('boite')->nullable(); // Boîte numérotée
            $table->integer('capacite_max')->default(50);
            $table->integer('pieces_actuelles')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emplacements');
    }
};