<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StudentAddFeesModel extends Model
{
    use HasFactory;
    protected $table = 'student_add_fees';

    static public function getSingle($id)
    {
        return self::find($id);
    }

       
        static public function getRecord( $remove_pagination = 0)
    {
        $return = self::select('student_add_fees.*', 'class.name as class_name', 'users.name as created_name',
                    'student.name as first_name', 'student.middle_name as middle_name', 'student.last_name as last_name')
                    ->join('class', 'class.id',  '=', 'student_add_fees.class_id')
                    ->join('users as student', 'student.id',  '=', 'student_add_fees.student_id')
                    ->join('users', 'users.id',  '=', 'student_add_fees.created_by')
                    ->where('student_add_fees.is_payment', '=', 1);
                        if(!empty(request()->get('student_id')))
                         {
                        $return =$return ->where('student_add_fees.student_id', '=' , request()->get('student_id'));
                        }
                        if(!empty(request()->get('student_name')))
                        {
                            $return =$return ->where('student.name', 'like','%'.request()->get('student_name').'%');
                        }
                        if(!empty(request()->get('student_last_name')))
                        {
                            $return =$return ->where('student.last_name', 'like','%'.request()->get('student_last_name').'%');
                        }
                        if (!empty(request()->get('class_id')))
                        {
                            $return = $return->where('student_add_fees.class_id', 'like', '%'.request()->get('class_id').'%');
                        }
                        if(!empty(request()->get('start_created_date')))
                        {
                            $return =$return ->whereDate('student_add_fees.created_at', '>=', request()->get('start_created_date'));
                        }
                        if(!empty(request()->get('end_created_date')))
                        {
                            $return =$return ->whereDate('student_add_fees.created_at', '<=', request()->get('end_created_date'));
                        }
                        if(!empty(request()->get('payment_type')))
                        {
                            $return = $return->where('student_add_fees.payment_type', '=', request()->get('payment_type'));
                        }
        $return  = $return ->orderBy('student_add_fees.id', 'desc');
                        if(!empty($remove_pagination))
                        {
                            $return  = $return->get();
                        }
                        else
                        {
                            $return  = $return->paginate(50);
                        }
                        
        return  $return ;
    }

    static public function getFees($student_id)
    {
        return self::select('student_add_fees.*', 'class.name as class_name', 'users.name as created_name')
                    ->join('class', 'class.id',  '=', 'student_add_fees.class_id')
                    ->join('users', 'users.id',  '=', 'student_add_fees.created_by')
                    ->where('student_add_fees.student_id', '=', $student_id)
                    ->where('student_add_fees.is_payment', '=', 1)
                    ->get();
    }

    static public function getPaidAmount($student_id, $class_id)
    {
        return self::where('student_add_fees.student_id', '=', $student_id)
                    ->where('student_add_fees.class_id', '=', $class_id)
                    ->where('student_add_fees.is_payment', '=', 1) 
                    ->sum('student_add_fees.paid_amount');
    }

    static public function getTotalTodayFees()
    {
        return self::where('student_add_fees.is_payment', '=', 1) 
                    ->whereDate('student_add_fees.created_at', '=', date('Y-m-d')) 
                    ->sum('student_add_fees.paid_amount');                   
    }

    
    static public function getTotalFees()
    {
        return self::where('student_add_fees.is_payment', '=', 1) 
                            ->sum('student_add_fees.paid_amount');                   
    }

    static public function  totalPaidAmountStudent($student_id)
    {
        return self::where('student_add_fees.is_payment', '=', 1) 
                            ->where('student_add_fees.student_id', '=', $student_id)
                            ->sum('student_add_fees.paid_amount');                   
    }
   

}
