<?php

namespace App\Imports;

use App\Models\Sector;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SectorImporter implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $names = Sector::pluck('name')->toArray();
        foreach ($collection as $row) {

            if (!in_array($row['name'], $names)) {
                Sector::create([
                    'name' => $row['name'],
                ]);
            }
        }
    }
}
