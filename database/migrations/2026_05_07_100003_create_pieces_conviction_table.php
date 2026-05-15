<?php
// database/migrations/2026_05_07_100003_create_pieces_conviction_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pieces_conviction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained('dossiers')->onDelete('cascade');
            $table->string('reference')->unique(); // PC-2026-0001
            $table->enum('categorie', [
                'arme', 'document', 'objet', 'argent', 'drogue', 
                'vehicule', 'electronique', 'bijou', 'liquide', 'autre'
            ]);
            $table->text('description');
            $table->integer('quantite')->default(1);
            $table->enum('etat', ['neuf', 'bon', 'use', 'endommage', 'perissable', 'dangereux']);
            $table->decimal('valeur_estimee', 15, 2)->nullable();
            $table->json('photos')->nullable(); // ['piece_001_1.jpg', ...]
            $table->string('qr_code')->unique();
            $table->foreignId('emplacement_id')->nullable()->constrained('emplacements')->nullOnDelete();
            $table->enum('statut', [
                'saisie', 'depot', 'restituee', 'detruite', 
                'vendue', 'archivee', 'expertise'
            ])->default('depot');
            $table->date('date_saisie');
            $table->date('date_peremption')->nullable(); // pour produits périssables
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces_conviction');
    }
};