<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\StudentAddFeesModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportCollectionFees implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
            'ID',
            'Student ID',
            'Student Name',
            'Class Name',
            'Total Amount',
            'Paid Amount',
            'Remaining Amount',
            'Payment Type',
            'Remark',
            'Created By',
            'Created Date'
        ];
    }

    public function map($value): array
    {
        $student_name =  $value->first_name. ' ' .$value->middle_name. ' '.$value->last_name;
        return [
            $value->id,
            $value->student_id,
            $student_name,
            $value->class_name,
            'Tsh '.number_format($value->total_amount,2),
            'Tsh '.number_format( $value->paid_amount, 2),
            'Tsh '.number_format($value->remaining_amount),
            $value->payment_type,
            $value->remark,
            $value->created_name,
            date('d-m-Y', strtotime($value->created_at))
        ];

    }
  
   
    public function collection()
    {
        $remove_pagination = 1;
        return StudentAddFeesModel::getRecord($remove_pagination);
    }
}

    

