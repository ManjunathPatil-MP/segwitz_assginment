<?php

namespace App\Exports;

use App\Models\Contacts;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contacts::where('client_id', '=', auth()->user()->id)->get();
    }
}
