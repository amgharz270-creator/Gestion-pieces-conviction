<?php
// database/migrations/2026_05_07_100006_create_inventaires_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // INV-2026-001
            $table->foreignId('realise_par')->constrained('users');
            $table->foreignId('verifie_par')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('type', ['complet', 'partiel', 'surprise']);
            $table->enum('statut', ['planifie', 'en_cours', 'termine', 'anomalie'])->default('planifie');
            $table->date('date_planifiee');
            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();
            $table->integer('pieces_attendues')->default(0);
            $table->integer('pieces_trouvees')->default(0);
            $table->integer('pieces_manquantes')->default(0);
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaires');
    }
};