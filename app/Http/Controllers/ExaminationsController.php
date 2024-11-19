<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\ExamModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ClassSubjectModel;
use App\Models\ExamScheduleModel;
use App\Models\AssignClassTeacherModel;
use App\Models\MarksRegisterModel;
use App\Models\MarksGradeModel;
Use App\Models\SettingModel;


class ExaminationsController extends Controller
{

    public function import_excel(Request $request)
    {
        dd($request->all());
    }
    
    public function exam_list()
    {
        $data['getRecord'] = ExamModel::getRecord();
        $data['header_title'] = 'Exam List';
        return view('admin.examinations.exam.list', $data);
    }
    public function exam_add()
    {
        $data['header_title'] = 'Exam Add';
        return view('admin.examinations.exam.add', $data);

    }
    
    public function exam_insert(Request $request)
    {
        $exam = new ExamModel;
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->created_by = Auth::user()->id;
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', 'Exam Successfully Created');
    }

    public function exam_edit($id)
    {
        $data['getRecord'] = ExamModel::getSingle($id);
        if(!empty( $data['getRecord']))
        {
            $data['header_title'] = 'Edit Exam';
            return view('admin.examinations.exam.edit', $data);
        }
        else
        {
            abort(404);
        }
    }

    public function exam_update($id, Request $request)
    {
        $exam =  ExamModel::getSingle($id);
        $exam->name = trim($request->name);
        $exam->note = trim($request->note);
        $exam->save();

        return redirect('admin/examinations/exam/list')->with('success', 'Exam Successfully Updated');
    }

    public function exam_delete($id)
    {
        $getRecord = ExamModel::getSingle($id);
        if(!empty( $getRecord))
        {
            $getRecord->is_delete = 1;
            $getRecord->save();
            return redirect()->back()->with('success', 'Exam Successfully Deleted');    
        }
        else
        {
            abort(404);
        }
    }

    public function exam_schedule(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        $result = array();
        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $getSubject = ClassSubjectModel::MySubject($request->get('class_id'));

            foreach( $getSubject as $value)
            {
                $dataS = array();
                $dataS['subject_id'] = $value->subject_id;
                $dataS['class_id'] = $value->class_id;
                $dataS['subject_name'] = $value->subject_name;
                $dataS['subject_type'] = $value->subject_type;

                $ExamSchedule = ExamScheduleModel::getRecordSingle($request->get('exam_id'),$request->get('class_id'), $value->subject_id);
                if(!empty($ExamSchedule))
                {
                    $dataS['exam_date'] = $ExamSchedule->exam_date;
                    $dataS['start_time'] = $ExamSchedule->start_time;
                    $dataS['end_time'] = $ExamSchedule->end_time;
                    $dataS['room_number'] = $ExamSchedule->room_number;
                    $dataS['full_marks'] = $ExamSchedule->full_marks;
                    $dataS['passing_marks'] = $ExamSchedule->passing_marks;

                }
                else
                {
                    $dataS['exam_date'] = '';
                    $dataS['start_time'] = '';
                    $dataS['end_time'] ='';
                    $dataS['room_number'] ='';
                    $dataS['full_marks'] = '';
                    $dataS['passing_marks'] = '';

                }
                $result[] =  $dataS;
            } 
        }
    
        $data['getRecord'] = $result;

        $data['header_title'] = 'Exam Schedule';
        return view('admin.examinations.exam_schedule', $data);

    }

    public function exam_schedule_insert(Request $request)
    {
        ExamScheduleModel::deleteRecord($request->exam_id, $request->class_id);
        if(!empty($request->schedule))
        {
            foreach($request->schedule as $schedule)
            {
                if(!empty( $schedule['subject_id']) && !empty( $schedule['exam_date']) && !empty( $schedule['start_time']) && 
                !empty( $schedule['end_time']) && !empty( $schedule['room_number']) && !empty( $schedule['full_marks']) && 
                !empty( $schedule['passing_marks']))
                {
                    $exam = new ExamScheduleModel;
                    $exam->exam_id = $request->exam_id;
                    $exam->class_id = $request->class_id;
                    $exam->subject_id = $schedule['subject_id'];
                    $exam->exam_date = $schedule['exam_date'];
                    $exam->start_time = $schedule['start_time'];
                    $exam->end_time = $schedule['end_time'];
                    $exam->room_number = $schedule['room_number'];
                    $exam->full_marks = $schedule['full_marks'];
                    $exam->passing_marks = $schedule['passing_marks'];
                    $exam->created_by = Auth::user()->id;
                    $exam->save();
                }               
            }
        }

        return redirect()->back()->with('success', 'Exam Schedule Successfully Saved');   
    }

    public function marks_register(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getExam'] = ExamModel::getExam();

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));

            $data['getStudent'] = User::getStudentclass( $request->get('class_id'));
        
        }

        $data['header_title'] = 'Marks Register';
        return view('admin.examinations.marks_register', $data);
    }

    public function marks_register_teacher(Request $request)
    {
         
        $data['getClass']  =AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        $data['getExam'] = ExamScheduleModel::getExamTeacher(Auth::user()->id);
      

        if(!empty($request->get('exam_id')) && !empty($request->get('class_id')))
        {
            $data['getSubject'] = ExamScheduleModel::getSubject($request->get('exam_id'), $request->get('class_id'));

            $data['getStudent'] = User::getStudentclass( $request->get('class_id'));
        
        }

        $data['header_title'] = 'Marks Register';
        return view('teacher.marks_register', $data);

    }

    public function submit_marks_register(Request $request)
    {
        $validation =0;
        if(!empty($request->mark))
        {
            foreach($request->mark as $mark)
            {
                $getExamSchedule = ExamScheduleModel::getSingle($mark['id']);
                $full_marks =  $getExamSchedule->full_marks;
                $test_one =  !empty($mark['test_one']) ? $mark['test_one'] : 0;
                $test_two =  !empty($mark['test_two']) ? $mark['test_two'] : 0;
                $exam =  !empty($mark['exam']) ? $mark['exam'] : 0;

                $full_marks =  !empty($mark['full_marks']) ? $mark['full_marks'] : 0;
                $passing_marks =  !empty($mark['passing_marks']) ? $mark['passing_marks'] : 0;

                $total_mark =  $test_one + $test_two + $exam ;

                if( $full_marks>=$total_mark )
                {
                    $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,
                    $mark['subject_id']);
                    if(!empty($getMark))
                    {
                        $save = $getMark;
                    }
                    else
                    {
                        $save               = new MarksRegisterModel;
                        $save->created_by	= Auth::user()->id;
                    }
               
                    $save->student_id   = $request->student_id;
                    $save->exam_id      = $request->exam_id;
                    $save->class_id     = $request->class_id;
                    $save->subject_id   = $mark['subject_id'];
                    $save->test_one     = $test_one;
                    $save->test_two      = $test_two;
                    $save->exam         = $exam;
                    $save->full_marks    = $full_marks;
                    $save->passing_marks = $passing_marks;

                    $save->save();
                }
                else
                {
                    $validation =1;
                }    
            }

            if(  $validation == 0)
            {
                $json['message'] = "Marks Successfully Saved";
            }
            else
            {
                $json['message'] = "Marks Successfully Saved . some subject marks is greater than full mark";
            }
        }
      
        echo json_encode($json);
    }

    public function single_submit_marks_register(Request $request)
    {
        $id = $request->id;
        $getExamSchedule = ExamScheduleModel::getSingle($id);

        $full_marks =  $getExamSchedule->full_marks;
        $test_one =  !empty($request->test_one) ? $request->test_one : 0;
        $test_two =  !empty($request->test_two) ? $request->test_two : 0;
        $exam =  !empty($request->exam) ? $request->exam : 0;

        $total_mark =  $test_one + $test_two + $exam ;

        if( $full_marks>=$total_mark )
        {
            $getMark = MarksRegisterModel::CheckAlreadyMark($request->student_id,$request->exam_id,$request->class_id,
            $request->subject_id);
            if(!empty($getMark))
            {
                $save = $getMark;
            }
            else
            {
                $save               = new MarksRegisterModel;
                $save->created_by	= Auth::user()->id;
            }
            $save->student_id   = $request->student_id;
            $save->exam_id      = $request->exam_id;
            $save->class_id     = $request->class_id;
            $save->subject_id   = $request->subject_id;
            $save->test_one     = $test_one;
            $save->test_two      = $test_two;
            $save->exam         = $exam;
            $save->full_marks    = $getExamSchedule->full_marks;
            $save->passing_marks = $getExamSchedule->passing_marks;
            
            $save->save();

            $json['message'] = "Marks Successfully Saved";
        }
        else
        {
            $json['message'] = "Your Total mark is greater than full mark";
        }

        
        echo json_encode($json);
        
    }

    public function marks_grade()
    {
        $data['getRecord'] = MarksGradeModel::getRecord();
        $data['header_title'] = 'Marks Grade';
        return view('admin.examinations.marks_grade.list', $data);

    }

    public function marks_grade_add()
    {
        $data['header_title'] = 'Add New Marks Grade';
        return view('admin.examinations.marks_grade.add', $data);

    }

    public function marks_grade_insert(Request $request)
    {
        $marks = new MarksGradeModel;
        $marks->name = trim($request->name);
        $marks->percentage_from = trim($request->percentage_from);
        $marks->percentage_to = trim($request->percentage_to);
        $marks->created_by = Auth::user()->id;
        $marks->save();

        return redirect('admin/examinations/marks_grade')->with('success', 'Marks Grade Successfully Created');
    }

    public function marks_grade_edit($id)
    {
        $data['getRecord'] = MarksGradeModel::getSingle($id);
        $data['header_title'] = 'Edit Marks Grade';
        return view('admin.examinations.marks_grade.edit', $data);

    }
    public function marks_grade_update($id, Request $request)
    {
        $marks = MarksGradeModel::getSingle($id);
        $marks->name = trim($request->name);
        $marks->percentage_from = trim($request->percentage_from);
        $marks->percentage_to = trim($request->percentage_to);
        $marks->created_by = Auth::user()->id;
        $marks->save();

        return redirect('admin/examinations/marks_grade')->with('success', 'Marks Grade Successfully updated');
    }

    public function marks_grade_delete($id)
    {
        $marks = MarksGradeModel::getSingle($id);
        $marks->delete();
        return redirect()->back()->with('success', 'Marks Grade Successfully Deleted');
    }
        // Student side

    public function MyExamTimetable()
    {
        $class_id = Auth::user()->class_id;
       $getExam = ExamScheduleModel::getExam($class_id);
       $result = array();
       foreach($getExam as $value)
       {
            $dataE = array();
            $dataE['name'] = $value->exam_name;
            $getExamTimetable =ExamScheduleModel::getExamTimetable( $value->exam_id,$class_id);

            $resultS = array();
            foreach($getExamTimetable as $value)
            {
                $dataS = array();
                $dataS['subject_name'] = $value->subject_name;
                $dataS['exam_date'] = $value->exam_date;
                $dataS['start_time'] = $value->start_time;
                $dataS['end_time'] = $value->end_time;
                $dataS['room_number'] = $value->room_number;
                $dataS['full_marks'] = $value->full_marks;
                $dataS['passing_marks'] = $value->passing_marks;
                $resultS[] = $dataS;
               
            }
            $dataE['exam'] =  $resultS;
            $result[]=  $dataE;
       }

       $data['getRecord'] = $result;

        $data['header_title'] = 'My Exam Timetable';
        return view('student.my_Exam_timetable', $data);
    }

    public function myExamResult()
    {
        $result = array();
        $getExam = MarksRegisterModel::getExam(Auth::user()->id);
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $dataE['exam_id'] = $value->exam_id;
            $getExamSubject = MarksRegisterModel::getExamSubject($value->exam_id, Auth::user()->id);
            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['test_one'] + $exam['test_two'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] =  $exam['subject_name'];
                $dataS['test_one'] =  $exam['test_one'];
                $dataS['test_two'] =  $exam['test_two'];
                $dataS['exam'] =  $exam['exam'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] =  $exam['full_marks'];
                $dataS['passing_marks'] =  $exam['passing_marks'];
                $dataSubject[] =  $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;     
        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Reault';
        return view('student.my_exam_result', $data);
        
    }

    public function myExamResultPrint(Request $request)
    {
        $exam_id = $request->exam_id;
        $student_id = $request->student_id;

        $data['getExam'] = ExamModel::getSingle( $exam_id);
        $data['getStudent'] = User::getSingle( $student_id);
        $data['getClass'] = MarksRegisterModel::getClass($exam_id, $student_id );
        $data['getSetting'] = SettingModel::getSingle();
        $getExamSubject = MarksRegisterModel::getExamSubject($exam_id, $student_id );
        $dataSubject = array();
        foreach($getExamSubject as $exam)
        {
            $total_score = $exam['test_one'] + $exam['test_two'] + $exam['exam'];
            $dataS = array();
            $dataS['subject_name'] =  $exam['subject_name'];
            $dataS['test_one'] =  $exam['test_one'];
            $dataS['test_two'] =  $exam['test_two'];
            $dataS['exam'] =  $exam['exam'];
            $dataS['total_score'] = $total_score;
            $dataS['full_marks'] =  $exam['full_marks'];
            $dataS['passing_marks'] =  $exam['passing_marks'];
            $dataSubject[] =  $dataS;
        }
        $data['getExamMarks'] = $dataSubject;

        return view('my_exam_result_print', $data);
    }
    // Teacher side

    public function MyExamTimetableTeacher()
    {
        $result =array();
        $getClass =AssignClassTeacherModel::getMyClassSubjectGroup(Auth::user()->id);
        foreach( $getClass as $class)
        {
            $dataC =array();
            $dataC['class_name'] =  $class->class_name;
            $getExam = ExamScheduleModel::getExam($class->class_id);
            $examArray = array();
            foreach( $getExam as $exam)
            {
                $dataE = array();
                $dataE['exam_name'] = $exam->exam_name; 
                $getExamTimetable =ExamScheduleModel::getExamTimetable( $exam->exam_id,$class->class_id);
                $subjectArray = array();
                foreach($getExamTimetable as $value)
                {
                    $dataS = array();
                    $dataS['subject_name'] = $value->subject_name;
                    $dataS['exam_date'] = $value->exam_date;
                    $dataS['start_time'] = $value->start_time;
                    $dataS['end_time'] = $value->end_time;
                    $dataS['room_number'] = $value->room_number;
                    $dataS['full_marks'] = $value->full_marks;
                    $dataS['passing_marks'] = $value->passing_marks;
                    $subjectArray[] = $dataS;
                   
                }

                $dataE['subject'] = $subjectArray;
                $examArray[] = $dataE;


            }
            $dataC['exam'] =  $examArray;
            $result[] = $dataC;
           
        }
          
        $data['getRecord'] = $result;
        
        $data['header_title'] = 'My Exam Timetable';
        return view('teacher.my_Exam_timetable', $data);

    }

    //Parent side

    public function ParentMyExamResult($student_id)
    {
        $data['getStudent'] = User::getSingle($student_id);
        $result = array();
        $getExam = MarksRegisterModel::getExam($student_id);
        foreach($getExam as $value)
        {
            $dataE = array();
            $dataE['exam_name'] = $value->exam_name;
            $getExamSubject = MarksRegisterModel::getExamSubject($value->exam_id, $student_id);
            $dataSubject = array();
            foreach($getExamSubject as $exam)
            {
                $total_score = $exam['test_one'] + $exam['test_two'] + $exam['exam'];
                $dataS = array();
                $dataS['subject_name'] =  $exam['subject_name'];
                $dataS['test_one'] =  $exam['test_one'];
                $dataS['test_two'] =  $exam['test_two'];
                $dataS['exam'] =  $exam['exam'];
                $dataS['total_score'] = $total_score;
                $dataS['full_marks'] =  $exam['full_marks'];
                $dataS['passing_marks'] =  $exam['passing_marks'];
                $dataSubject[] =  $dataS;
            }
            $dataE['subject'] = $dataSubject;
            $result[] = $dataE;     
        }
        $data['getRecord'] = $result;
        $data['header_title'] = 'My Exam Reault';
        return view('parent.my_exam_result', $data);
        
    }
}
