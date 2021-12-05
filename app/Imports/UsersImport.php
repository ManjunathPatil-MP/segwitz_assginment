<?php

namespace App\Imports;

use App\Models\Contacts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacts([
            'name'     => $row['name'],
            'phone'    => $row['phone'], 
            'client_id'    => auth()->user()->id,
        ]);
    }
}
