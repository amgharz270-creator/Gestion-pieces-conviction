<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PieceConviction;
use Illuminate\Support\Str;

class GenerateQRCodes extends Command
{
    protected $signature = 'qr:generate';
    protected $description = 'Générer des QR codes pour toutes les pièces';

    public function handle()
    {
        $pieces = PieceConviction::whereNull('qr_code')->orWhere('qr_code', '')->get();
        
        if ($pieces->isEmpty()) {
            $this->info('Toutes les pièces ont déjà des QR codes!');
            return;
        }
        
        $count = 0;
        foreach ($pieces as $piece) {
            $piece->qr_code = 'QR-' . $piece->id . '-' . Str::random(8);
            $piece->save();
            $count++;
            $this->info("QR code généré pour: " . $piece->reference);
        }
        
        $this->info("$count QR codes générés avec succès!");
    }
}