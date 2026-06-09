<?php

namespace App\Exports;

use App\Models\Inventaire;
use Maatwebsite\Excel\Concerns\FromCollection;

class InventairesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventaire::all();
    }
}
