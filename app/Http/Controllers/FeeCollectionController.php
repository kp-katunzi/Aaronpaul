<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\SettingModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportCollectionFees;
use Stripe\Stripe;
use Illuminate\Support\Facades\Session;

class FeeCollectionController extends Controller
{
    public function collect_fees(Request $request)
    {
        $data['getClass'] =  ClassModel::getClass();
        if(!empty($request->all()))
        {
            $data['getRecord'] = User::getCollectFeesStudent();
        }
        $data['header_title'] = 'Collect Fees';
        return view('admin.fees_collection.collect_fees', $data);
    }

    public function CollectFeesReport()
    {
        $data['getClass'] =  ClassModel::getClass();
        $data['getRecord'] =  StudentAddFeesModel::getRecord();
        $data['header_title'] = 'Collect Fees Report';
        return view('admin.fees_collection.collect_fees_report', $data);

    }

    public function export_collect_fees_report( Request $request)
    {
        return Excel::download(new ExportCollectionFees, 'CollectFeesReport_'.date('d-m-Y').'.xls');
      
    }

    public function collect_fees_add($student_id)
    {
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);
        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        $data['header_title'] = 'Add Collect Fees';
        return view('admin.fees_collection.add_collect_fees', $data);
    }

    public function collect_fees_insert($student_id, Request $request)
    {
        $getStudent = User::getSingleClass($student_id);
        $paid_amount= StudentAddFeesModel::getPaidAmount($student_id, $getStudent->class_id);
        if(!empty($request->amount))
        {
            $remainingAmount = $getStudent->amount - $paid_amount;

            if( $remainingAmount >=$request->amount)
            {
                $remaining_amount_user =  $remainingAmount - $request->amount;
    
                $payment = new StudentAddFeesModel;
    
                $payment->student_id = $student_id;
                $payment->class_id = $getStudent->class_id;$request->amount;
                $payment->paid_amount = $request->amount;
                $payment->total_amount  = $remainingAmount;
                $payment->remaining_amount  = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;  
                $payment->is_payment = 1;
                $payment->save();
                return redirect()->back()->with('success', 'Fees Successfully Add');  
            }
            else
            {
                return redirect()->back()->with('error', 'Your amount go to greater than remaining amount'); 
            }     
        } 
        else
        {
            return redirect()->back()->with('error', 'Your need to add atleast Tsh 1'); 
        }
    }

    // Student side

    public function CollectFeesStudent(Request $request)
    {
        $student_id = Auth::user()->id;
        $data['getFees'] = StudentAddFeesModel::getFees($student_id);

        $getStudent = User::getSingleClass($student_id);
        $data['getStudent'] = $getStudent;
        $data['header_title'] = 'Fees Collection';

        $data['paid_amount'] = StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);

        return view('student.fees_collection', $data);

    }

    public function CollectFeesStudentPayment(Request $request)
    {
        $getStudent = User::getSingleClass(Auth::user()->id);
        $paid_amount= StudentAddFeesModel::getPaidAmount(Auth::user()->id, Auth::user()->class_id);
        if(!empty($request->amount))
        {   
            $remainingAmount = $getStudent->amount - $paid_amount;

            if( $remainingAmount >=$request->amount)
            {
                $remaining_amount_user =  $remainingAmount - $request->amount;
    
                $payment = new StudentAddFeesModel;
    
                $payment->student_id = Auth::user()->id;
                $payment->class_id = Auth::user()->class_id;
                $payment->paid_amount = $request->amount;
                $payment->total_amount  = $remainingAmount;
                $payment->remaining_amount  = $remaining_amount_user;
                $payment->payment_type = $request->payment_type;
                $payment->remark = $request->remark;
                $payment->created_by = Auth::user()->id;  
                $payment->save();

                $getSetting = SettingModel::getSingle();
                if($request->payment_type == 'paypal')
                {
                    $query = array();
                    $query['business'] = $getSetting->paypal_email; 
                    $query['cmd']          = '_xclick';
                    $query['item_name']    = "Student Fees"; 
                    $query['no_shipping']   = '1';
                    $query['item_number']    = $payment->id;
                    $query['amount']        = $request->amount;
                    $query['currency_code'] = 'USD';
                    $query['cancel_return'] = url('student/paypal/payment-error');
                    $query['return']         = url('student/paypal/payment-succuss');

                    $query_string = http_build_query($query);

                    // header('location:https://www.paypal.com/cgi-bin/webscr'. $query_string);
                    header('Location: https://sandbox.paypal.com/cgi-bin/webscr?' . $query_string);

                    exit();

                }
                elseif($request->payment_type == 'Stripe')
                {
                    $setPublicKey = $getSetting->stripe_key;
                    $setApiKey =   $getSetting->stripe_secre;

                    Stripe::setApiKey($setApiKey);
                    $finalPrice = $request->amount*100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => Auth::user()->email,
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'name'   => 'Student Fees',
                            'description' => 'Student Fees',
                            'images' => [ url('asset/img/logo-2x.png')],
                            'amount' => Intval($finalPrice),
                            'currency' => 'usd',
                            'quantity' => 1,
                        ]],
                        'success_url' => url('student/stripe/payment_success'),
                        'cancel_url' => url('student/stripe/payment_error')
                        ]); 

                        $data['session_id'] = $session['id'];
                        Session ::put('stripe_session_id', $session['id'] );
                        $data['setPublicKey'] =   $setPublicKey;

                        return view('frontend.payment.stripe_change');
                   
                    
                }
                return redirect()->back()->with('success', 'Fees Successfully Add');  
            }
            else
            {
                return redirect()->back()->with('error', 'Your amount go to greater than remaining amount'); 
            }

        }
        else
        {
            return redirect()->back()->with('error', 'Your need to add atleast Tsh 1');  
        }

    }

    public function PaymentSuccessStripe(Request $request)
    {

    }

    public function PaymentError()
    {
        return redirect('student/fees_collection')->with('error', 'due to some error please try again');
    }

    public function PaymentSuccuss(Request $request)
    {
       dd($request->all());
    }



}
