<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class UserManagementController extends Controller
{   
   public function view_users(Request $request)
    {
        $data['header_title'] = 'Users List ';
        if ($request->ajax()) {
            $users = DB::table('users')
                ->select(['id', 'name', 'middle_name', 'last_name', 'email', 'user_type', 'created_at']);

            return DataTables::of($users)
                ->addColumn('name', function ($row) {
                    return $row->name . ' ' . $row->middle_name . ' ' . $row->last_name;
                })
                ->addColumn('user_type', function ($row) {
                    // Map user_type number to user role name
                    $userRoles = [
                        1 => 'Admin',
                        2 => 'Teacher',
                        3 => 'Student',
                        4 => 'Parent',
                        5 => 'Accountant'
                    ];
                    return $userRoles[$row->user_type] ?? 'Unknown';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<a href="' . url('admin/User_Management/view/' . $row->id . '/' . $row->user_type) . '" 
                                        class="btn btn-sm btn-primary fas fa-eye" title="View"  target="_blank"></a>
                                <a href="' . url('admin/User_Management/edit/' . $row->id) . '" 
                                        class="btn btn-sm btn-primary fas fa-edit" title="Edit"></a>
                                <a href="' . url('admin/User_Management/delete/' . $row->id) . '" 
                                        class="btn btn-sm btn-danger fas fa-trash-alt" title="Delete"></a>';
                    return $buttons;

                })
                ->make(true);
        }
        return view('admin.user_management.user',  $data);
        return abort(404, 'Not Found');
    }

    public function view_user_role($id, $role)
    {
        $role = (int) $role;
        
        $user = User::find($id); 
        $className = ClassModel::find($user->class_id)->name ?? 'N/A';

        // Fetch user data by ID
        // $user = DB::table('users')->where('id', $id)->first();
        $userData = DB::table('users')->where('id', $id)->first();
        $user = User::find($userData->id);


        if (!$user) {
            // Abort with a 404 error if the user does not exist
            return abort(404, 'User not found');
        }
        Log::info('User Data:', (array) $user);
        Log::info('Role:', [$role]);
        // Map the role to the corresponding Blade view
        $bladeView = match ($role) {
            1 => 'admin.user_management.view_admin',      // Admin view
            2 => 'admin.user_management.view_teacher',    // Teacher view
            3 => 'admin.user_management.view_student',    // Student view
            4 => 'admin.user_management.view_parent',     // Parent view
            default => abort(404, 'Invalid role'),        // Handle invalid roles
        };
        // Pass the user data to the selected Blade view
        return view($bladeView, compact('user', 'className'));


    }

}
