<?php

namespace App\Exports;

use App\Models\Restitution;
use Maatwebsite\Excel\Concerns\FromCollection;

class RestitutionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Restitution::all();
    }
}
