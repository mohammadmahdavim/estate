<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Models\Lesson;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $codes = Book::pluck('code')->toArray();
        foreach ($collection as $row) {
            if (!in_array($row['code'], $codes)) {
                Book::create([
                    'code' => $row['code'],
                    'name' => $row['name'],
                    'grade' => $row['grade'],
                    'lesson' => $row['lesson'],
                ]);

            }
            $lesson = Lesson::where('name', $row['lesson'])->first();
            if (!$lesson and $row['lesson']) {
                Lesson::create([
                    'name' => $row['lesson']
                ]);
            }
        }
    }
}
