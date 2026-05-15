<?php
// database/migrations/2026_05_07_100004_create_mouvements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piece_id')->constrained('pieces_conviction')->onDelete('cascade');
            $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('to_user_id')->constrained('users');
            $table->foreignId('from_emplacement_id')->nullable()->constrained('emplacements')->nullOnDelete();
            $table->foreignId('to_emplacement_id')->nullable()->constrained('emplacements')->nullOnDelete();
            $table->enum('type', [
                'saisie', 'transfert', 'restitution', 'destruction', 
                'vente', 'expertise', 'audience', 'retour_depot'
            ]);
            $table->text('motif')->nullable();
            $table->string('document_reference')->nullable(); // PV, ordonnance...
            $table->timestamp('date_mouvement');
            $table->timestamp('date_retour_prevue')->nullable(); // pour expertise
            $table->timestamp('date_retour_effective')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvements');
    }
};