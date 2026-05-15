<?php
// database/migrations/2026_05_07_100001_create_dossiers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers', function (Blueprint $table) {
            $table->id();
            $table->string('numero_dossier')->unique(); // ex: 2026/123
            $table->enum('type_affaire', ['penale', 'civile', 'commerciale', 'administrative']);
            $table->text('parties'); // noms des parties
            $table->foreignId('juge_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('statut', ['en_cours', 'juge', 'appel', 'cassation', 'clos'])->default('en_cours');
            $table->date('date_ouverture')->default(now());
            $table->date('date_cloture')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers');
    }
};