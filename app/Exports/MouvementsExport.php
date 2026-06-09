<?php

namespace App\Exports;

use App\Models\Mouvement;
use Maatwebsite\Excel\Concerns\FromCollection;

class MouvementsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mouvement::all();
    }
}
