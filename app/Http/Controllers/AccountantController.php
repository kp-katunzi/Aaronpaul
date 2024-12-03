<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class AccountantController extends Controller
{
  
     public function list()
    {
  
        return view('admin.accountant.list');
    }
}
