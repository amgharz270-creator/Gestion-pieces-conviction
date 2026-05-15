<?php
// database/migrations/2026_05_07_100005_create_restitutions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restitutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piece_id')->constrained('pieces_conviction')->onDelete('cascade');
            $table->string('demandeur_nom');
            $table->string('demandeur_cin')->nullable(); // CIN marocain
            $table->enum('type_demandeur', ['victime', 'prevenu', 'tiers', 'avocat', 'heritier']);
            $table->text('motif_demande');
            $table->string('jugement_reference')->nullable();
            $table->date('date_jugement')->nullable();
            $table->enum('statut', ['en_attente', 'approuvee', 'refusee', 'effectuee'])->default('en_attente');
            $table->foreignId('approuve_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('date_approbation')->nullable();
            $table->timestamp('date_restitution')->nullable();
            $table->string('receveur_nom')->nullable();
            $table->string('receveur_cin')->nullable();
            $table->string('receveur_signature')->nullable(); // path image signature
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restitutions');
    }
};