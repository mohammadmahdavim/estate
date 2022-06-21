<?php

namespace App\Imports;

use App\Models\Field;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UploadUsers implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $codes = User::pluck('national_code')->toArray();
        foreach ($collection as $row) {
            $user=User::where('national_code',$row['national_code'])->first();
            if (!$user and $row['national_code']) {
                $field = Field::where('title', $row['field'])->pluck('id')->first();
                if (!$field and $row['field']) {
                    $field = Field::create([
                        'title' => $row['field'],
                    ])->id;
                }
                $university = University::where('title', $row['university'])->pluck('id')->first();
                if (!$university and $row['university']) {
                    $university = University::create([
                        'title' => $row['field'],
                    ])->id;
                }
                User::create([
                    'first_name' => $row['name'],
                    'last_name' => '-',
                    'rank' => $row['rank'],
                    'national_code' => $row['national_code'],
                    'password' => Hash::make($row['national_code']),
                    'field_id' => $field,
                    'university_id' => $university,
                ]);
            }
        }
    }
}
