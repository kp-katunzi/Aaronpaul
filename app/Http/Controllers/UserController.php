<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\SettingModel;


class UserController extends Controller
{
    public function Setting()
    {
        $data['getRecord'] = SettingModel::getSingle();
        $data['header_title'] = ' Setting';
        return view('admin.setting', $data);
    }

    public function updateSetting(Request $request)
    {
       
        $Setting = SettingModel::getSingle();
        $Setting->paypal_emali = trim($request->paypal_emali);
        $Setting->stripe_key = trim($request->stripe_key);
        $Setting->stripe_secret = trim($request->stripe_secret);
        $Setting->college_name = trim($request->college_name);
        $Setting->exam_description = trim($request->exam_description);
        if(!empty($request->file('logo')))
        {
            $ext = $request->file('logo')->getClientOriginalExtension();
            $file = $request->file('logo');
            $randomStr = date('Ymdhis').Str::random(10);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/setting/', $filename);
            $Setting->logo =  $filename;
        }       
        if(!empty($request->file('favicon_icon')))
        {
            $ext = $request->file('favicon_icon')->getClientOriginalExtension();
            $file = $request->file('favicon_icon');
            $randomStr = date('Ymdhis').Str::random(10);
            $favicon_icon = strtolower($randomStr).'.'.$ext;
            $file->move('upload/setting/', $favicon_icon);
            $Setting->favicon_icon =  $favicon_icon;
        }    

        if(!empty($request->file('favicon_login')))
        {
            $ext = $request->file('favicon_login')->getClientOriginalExtension();
            $file = $request->file('favicon_login');
            $randomStr = date('Ymdhis').Str::random(10);
            $favicon_login = strtolower($randomStr).'.'.$ext;
            $file->move('upload/setting/', $favicon_login);
            $Setting->favicon_login =  $favicon_login;
        }  

        $Setting->save();
        return redirect()->back()->with('success', 'Settting Successfully Updated');
    }

    public function MyAccount()
    {
        $data['getRecord'] = User::getSingle(Auth::user()->id);
        $data['header_title'] = ' My Account';
        if(Auth::user()->user_type == 1)
        {
            return view('admin.my_account', $data);
           
        }    
        else if(Auth::user()->user_type == 2)
        {
            return view('teacher.my_account', $data);
           
        }
        else if(Auth::user()->user_type == 3)
        {
            return view('student.my_account', $data);
        }
        else if(Auth::user()->user_type == 4)
        {
            return view('parent.my_account', $data);
        }
                 
    }

    public function UpdateMyAccountAdmin(Request $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,        
         ]);
         $admin =User:: getSingle($id);
         $admin->name = trim( $request->name);
         $admin->email = trim( $request->email);
         $admin->save();

        return redirect()->back()->with('success', 'Account Successfully Updated');
    }

    public function UpdateMyAccount(Request $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
             'marital_status' =>'max:50',
             'phone_number' =>'max:15|min:10',
         ]);
     
         $teacher =User:: getSingle($id);
         $teacher->name = trim( $request->name);
         $teacher->last_name = trim( $request->last_name);
         $teacher->gender = trim( $request->gender);
         if(!empty( $request->date_of_birth))
         {
             $teacher->date_of_birth = trim( $request->date_of_birth);
         }
         $teacher->marital_status = trim( $request->marital_status);
         $teacher->phone_number = trim( $request->phone_number);
        
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
         $teacher->email = trim( $request->email);
         $teacher->save();

          return redirect()->back()->with('success', 'Account Successfully Updated');
    }

    public function UpdateMyAccountStudent(Request $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'height' =>'max:10',
            'phone_number' =>'max:15|min:10',
            'blood_group ' =>'max:10',
            'religion' =>'max:50',
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
        $student->phone_number = trim( $request->phone_number);
      
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
        $student->nida = trim( $request->nida);
        $student->email = trim( $request->email);
        $student->save();
        return redirect()->back()->with('success', 'Account Successfully Update');
    }

    public function UpdateMyAccountParent(Request $request)
    {
        $id = Auth::user()->id;
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' =>'max:15|min:10',
            'address ' =>'max:255',
            'occupation' =>'max:255',
        ]);
    
        $parent =User:: getSingle($id);

        $parent->name = trim( $request->name);
        $parent->last_name = trim( $request->last_name);
        $parent->gender = trim( $request->gender);
        $parent->phone_number = trim( $request->phone_number);    

        if(!empty($request->file('profile_photo')))
        {
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $parent->profile_photo =  $filename;
        }    
        $parent->occupation = trim( $request->occupation);
        $parent->address = trim( $request->address);
        $parent->email = trim( $request->email);

        $parent->save();;

        return redirect()->back()->with('success', 'Account Successfully Update');
    }

    public function change_password()
    {
        $data['header_title'] = 'Change Password';
        return view('profile.change_password', $data);
    }

    public function update_change_password(Request $request)
    {
        $user = User::getSingle(Auth::user()->id);
        if(Hash::check($request->old_password, $user->password))
        {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('success','Password  Successfully Updated');

        }
        else
        {
            return redirect()->back()->with('error','Old password is not correct');
        }
    }
}
