<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Exports\ExportStudent;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class StudentController extends Controller
{
    public function export_excel(Request $request)
    {
        return Excel::download(new ExportStudent, 'Student_'.date('d-m-Y').'.xls');  
         
       
    }
    public function list()
    {
        $data['getRecord'] = User::getStudent();
        $data['header_title'] = 'Student List';
        return view('admin.student.list', $data);

    }

    public function add()
    {
        $data['getClass'] =ClassModel::getClass();
        $data['header_title'] = 'Add New Student ';
        return view('admin.student.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'height' =>'max:10',
            'phone_number' =>'max:15|min:10',
            'blood_group ' =>'max:10',
            'religion' =>'max:50',
            'admission_number' =>'max:50',
            'roll_number' =>'max:50',
            'weight' =>'max:10',
        ]);
    
        $student = new User;
        $student->name = trim( $request->name);
        $student->middle_name = trim( $request->middle_name);
        $student->last_name = trim( $request->last_name);
        $student->gender = trim( $request->gender);
        if(!empty( $request->date_of_birth))
        {
            $student->date_of_birth = trim( $request->date_of_birth);
        }
        $student->religion = trim( $request->religion);
        $student->admission_number = trim( $request->admission_number);
        $student->roll_number = trim( $request->roll_number);
        $student->class_id = trim( $request->class_id);
        $student->phone_number = trim( $request->phone_number);
        if(!empty($request->admission_date))
        {
            $student->admission_date = trim( $request->admission_date);
        }     
        if(!empty($request->file('profile_photo')))
        {
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $student->profile_photo =  $filename;
        }    
        $student->blood_group = trim( $request->blood_group);
        $student->height = trim( $request->height);
        $student->weight = trim( $request->weight);
        $student->form_four_regno = trim( $request->form_four_regno);
        $student->nida = trim( $request->nida);
        $student->status = trim( $request->status);
        $student->email = trim( $request->email);
        $student->password = Hash::make( $request->password);
        $student->user_type = 3;
        $student->save();

         return redirect('admin/student/list')->with('success', 'Student Successfully Created');

    }

    public function edit($id)
    {
        $data['getRecord'] =User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['getClass'] =ClassModel::getClass();
            $data['header_title'] = 'Edit Student ';
            return view('admin.student.edit', $data);
        }
        else
        {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'height' =>'max:10',
            'phone_number' =>'max:15|min:10',
            'blood_group ' =>'max:10',
            'religion' =>'max:50',
            'admission_number' =>'max:50',
            'roll_number' =>'max:50',
            'weight' =>'max:10',
        ]);
    
        $student =User:: getSingle($id);
        $student->name = trim( $request->name);
        $student->middle_name = trim( $request->middle_name);
        $student->last_name = trim( $request->last_name);
        $student->gender = trim( $request->gender);
        if(!empty( $request->date_of_birth))
        {
            $student->date_of_birth = trim( $request->date_of_birth);
        }
        $student->religion = trim( $request->religion);
        $student->admission_number = trim( $request->admission_number);
        $student->roll_number = trim( $request->roll_number);
        $student->class_id = trim( $request->class_id);
        $student->phone_number = trim( $request->phone_number);
        if(!empty($request->admission_date))
        {
            $student->admission_date = trim( $request->admission_date);
        }     
        if(!empty($request->file('profile_photo')))
        {
            if(!empty($student->getprofile()))
            {
                unlink('upload/profile/'.$student->profile_photo);
            }
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = Str::random(20);
            $filename = date('Ymdhis').strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $student->profile_photo =  $filename;
        }    
        $student->blood_group = trim( $request->blood_group);
        $student->height = trim( $request->height);
        $student->weight = trim( $request->weight);
        $student->form_four_regno = trim( $request->form_four_regno);
        $student->nida = trim( $request->nida);
        $student->status = trim( $request->status);
        $student->email = trim( $request->email);

        if(!empty( $request->password))
        {
            $student->password = Hash::make( $request->password);
        }
        
        $student->save();

         return redirect('admin/student/list')->with('success', 'Student Successfully Updated');
    }

    public function delete($id)
    {
        $getRecord =User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete =1;
            $getRecord->save();

            return redirect()->back()->with('success', 'Student Successfully Delete');
        }
        else
        {
            abort(404);
        }
    }

    // Teacher side work

    public function MyStudent()
    {
        $data['getRecord'] = User::getTeacherStudent(Auth::user()->id);
        $data['header_title'] = 'My Student List';
        return view('teacher.my_student', $data);

    }
}
