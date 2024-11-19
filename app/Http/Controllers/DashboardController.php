<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ExamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentAddFeesModel;
use App\Models\SubjectModel;
use App\Models\AssignClassTeacherModel;
use App\Models\NoticeBoardModel;
use App\Models\ClassSubjectModel;
class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['header_title'] = 'Dashboard';
        if(Auth::user()->user_type == 1)
        {
            $data['getTotalFees'] = StudentAddFeesModel::getTotalFees();
            $data['getTotalTodayFees'] = StudentAddFeesModel::getTotalTodayFees();
            $data['totalAdmin'] = User::getTotalUser(1);
            $data['totalTeacher'] = User::getTotalUser(2);
            $data['totalStudent'] = User::getTotalUser(3);
            $data['totalParent'] = User::getTotalUser(4);

            $data['totalExam'] = ExamModel::gettotalExam();
            $data['totalClass'] = ClassModel::getTotalClass();
            $data['totalSubject'] = SubjectModel::getTotalSubject();
           
            return view('admin.dashboard', $data);
        }
        else if(Auth::user()->user_type == 2)
        {
            $data['totalStudent'] = User::getTeacherStudentCount(Auth::user()->id);
            $data['totalClass'] = AssignClassTeacherModel::getMyClassSubjectGroupCount(Auth::user()->id);
            $data['totalSubject'] = AssignClassTeacherModel::getMyClassSubjectCount(Auth::user()->id);
            $data['totalNoticeBoard'] =  NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            return view('teacher.dashboard', $data);
        }
        else if(Auth::user()->user_type == 3)
        {
            $data['totalPaidAmount'] = StudentAddFeesModel::totalPaidAmountStudent(Auth::user()->id);
            $data['totalSubject'] =  ClassSubjectModel::MySubjectTotal(Auth::user()->class_id);
            $data['totalNoticeBoard'] =  NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            
           
            return view('student.dashboard', $data);
        }
        else if(Auth::user()->user_type == 4)
        {

            $data['totalPaidAmount'] = StudentAddFeesModel::totalPaidAmountStudent(Auth::user()->id);
            $data['totalStudent'] = User::getMyStudentCount(Auth::user()->id);
            $data['totalNoticeBoard'] =  NoticeBoardModel::getRecordUserCount(Auth::user()->user_type);
            
            return view('parent.dashboard', $data);
          
        }     

    }
    
}
