<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use  App\Exports\ExportTeacher;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function export_teacher(Request $request)
    {
        return Excel::download(new ExportTeacher, 'Teacher_'.date('d-m-Y').'.xls');  
       
    }
    public function list()
    {
        
        $data['getRecord'] = User::getTeacher();
        $data['header_title'] = 'Teacher List';
        return view('admin.teacher.list', $data);      
    }

    public function add()
    {
        //$data['getClass'] =ClassModel::getClass();
        $data['header_title'] = 'Add New Teacher ';
        return view('admin.teacher.add', $data);
    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users',
            'marital_status' =>'max:50',
            'phone_number' =>'max:15|min:10',
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
        $student->marital_status = trim( $request->marital_status);
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
        $student->address = trim( $request->address);
        $student->paddress = trim( $request->paddress);
        $student->qualification = trim( $request->qualification);
        $student->work_experience = trim( $request->work_experience);
        $student->note = trim( $request->note);
        $student->status = trim( $request->status);
        $student->email = trim( $request->email);
        $student->password = Hash::make( $request->password);
        $student->user_type = 2;
        $student->save();

         return redirect('admin/teacher/list')->with('success', 'Teacher Successfully Created');
    }

    public function edit($id)
    {
        $data['getRecord'] =User::getSingle($id);
        if(!empty($data['getRecord']))
        {
            $data['header_title'] = 'Edit Teacher ';
            return view('admin.teacher.edit', $data);
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
            'marital_status' =>'max:50',
            'phone_number' =>'max:15|min:10',
        ]);
    
        $teacher =User:: getSingle($id);
        $teacher->name = trim( $request->name);
        $teacher->middle_name = trim( $request->middle_name);
        $teacher->last_name = trim( $request->last_name);
        $teacher->gender = trim( $request->gender);
        if(!empty( $request->date_of_birth))
        {
            $teacher->date_of_birth = trim( $request->date_of_birth);
        }
        $teacher->marital_status = trim( $request->marital_status);
        $teacher->phone_number = trim( $request->phone_number);
        if(!empty($request->admission_date))
        {
            $teacher->admission_date = trim( $request->admission_date);
        }     
        if(!empty($request->file('profile_photo')))
        {
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $teacher->profile_photo =  $filename;
        }    
        $teacher->address = trim( $request->address);
        $teacher->paddress = trim( $request->paddress);
        $teacher->qualification = trim( $request->qualification);
        $teacher->work_experience = trim( $request->work_experience);
        $teacher->note = trim( $request->note);
        $teacher->status = trim( $request->status);
        $teacher->email = trim( $request->email);
        if(!empty( $request->password))
        {
            $teacher->password = Hash::make( $request->password);
        }
        $teacher->save();

         return redirect('admin/teacher/list')->with('success', 'Teacher Successfully Updated');

    }

    public function delete($id)
    {
        $getRecord =User::getSingle($id);
        if(!empty($getRecord))
        {
            $getRecord->is_delete =1;
            $getRecord->save();

            return redirect()->back()->with('success', 'Teacher Successfully Delete');
        }
        else
        {
            abort(404);
        }
        

    }
}
