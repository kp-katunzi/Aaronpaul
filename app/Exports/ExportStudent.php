<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudent implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

   
    public function headings(): array
    {
                       
        return [
            'ID',
            'Student Name',
            'Parent Name',
            'Email',
            'Gender',
            'Date of Birth',
            'Religion',
            'Admission Number',
            'Roll Number',
            'Class',
            'Phone Number',
            'Admission Date',
            'Blood Group',
            'Height',
            'Weight',
            'Form Four RegNo',
            'NIDA',
            'Status',
            'Created Date'
        ];
    }

    public function map($value): array
    {
        $student_name = $value->name. ' ' .$value->middle_name. ' '.$value->last_name;
        $parent_name =  $value->parent_name. ' ' .$value->parent_last_name;
        $date_of_birth ="";
        if(!empty( $value->date_of_birth ))
        {
            $date_of_birth =date('d-m-Y', strtotime( $value->date_of_birth ));
        }
        $admission_date = "";
        if(!empty( $value->admission_date ))
        {
            $admission_date = date('d-m-Y', strtotime( $value->admission_date ));
        }

        $status = ($value->status ==0)? 'Active': 'Inactive';
                            
                         
        return [
            $value->id,
            $student_name,
            $parent_name,
            $value->email,
            $value->gender,
            $date_of_birth,
            $value->religion,
            $value->admission_number,
            $value->roll_number,
            $value->class_name,
            $value->phone_number,
            $admission_date,
            $value->blood_group, 
            $value->height,
            $value->weight,
            $value->form_four_regno,
            $value->nida,
            $status,
            date('d-m-Y H: i A',strtotime($value->created_at))    
        ];

    }
  
   
    public function collection()
    {
        $remove_pagination = 1;
        return User::getStudent($remove_pagination);
    }
}
