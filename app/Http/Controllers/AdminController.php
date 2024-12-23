<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function list()
    {
        $data['getRecord'] = User::getAdmin();
        $data['header_title'] = 'Admin List';
        return view('admin.admin.list', $data);
        session()->flush();
    }

    public function add()
    { 
        $data['header_title'] = 'Add New Admin';
        return view('admin.admin.add', $data);

    }

    public function insert(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users'
        ]);
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type = 1;
        if(!empty($request->file('profile_photo')))
        {
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = date('Ymdhis').Str::random(20);
            $filename = strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $user->profile_photo =  $filename;
        }    
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin successfully created');

    }
    public function edit($id)
    { 
        $data['getRecord'] = User::getSingle($id);
        if(!empty( $data['getRecord']))
        {
            $data['header_title'] = 'Edit Admin';
            return view('admin.admin.edit', $data);
        }
        else
        {
            abort(404);
        }
       
    }

    public function update($id, Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:users,email,'.$id
        ]);
        $user = User::getSingle($id);
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        if(!empty($request->file('profile_photo')))
        {
            if(!empty($user->getprofile()))
            {
                unlink('upload/profile/'.$user->profile_photo);
            }
            $ext = $request->file('profile_photo')->getClientOriginalExtension();
            $file = $request->file('profile_photo');
            $randomStr = Str::random(20);
            $filename = date('Ymdhis').strtolower($randomStr).'.'.$ext;
            $file->move('upload/profile/', $filename);
            $user->profile_photo =  $filename;
        }    
        if(!empty($request->password))
        {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect('admin/admin/list')->with('success', 'Admin successfully updated');
        

    }

    public function delete($id)
    {
        $user = User::getSingle($id);
        $user->is_delete = 1;
        $user->save();
        return redirect()->back()->with('success', 'Admin successfully Deleted');
    }



}
