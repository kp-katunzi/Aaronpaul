<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\MarksRegisterModel;

class MarksExcell implements ToCollection, ToModel, WithHeadings
{
    /**
    * @param Collection $collection
    */

    public function model(array $row)
    {
        return new marks([
            'name' => $row['name'],  // Ensure these match your column headers in Excel
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'exam_marks' => $row['exam_marks'], // You can add more fields as needed
        ]);
    }
    public function collection(Collection $collection)
    {
        //
    }
}
