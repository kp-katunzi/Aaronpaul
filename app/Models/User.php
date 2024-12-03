<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getTotalUser($user_type)
    {
        return self::select('users.id')
                    ->where('user_type', '=', $user_type)
                    ->where('is_delete', '=',0)
                     ->count();
        
    }

    static public function getSingleClass($id)
    {
        return self::select('users.*', 'class.amount', 'class.name as class_name')
                    ->join('class', 'class.id', 'users.class_id')
                    ->where('users.id', '=', $id)
                    ->first();
    }

    static public function SearchUser($search)
{
    $return = self::select('users.*')
            ->where(function ($query) use ($search) {
                    $query->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.last_name', 'like', '%' . $search . '%');
            })
                ->limit(10)
                ->get();

        return $return;
}


static public function getAccountant()
    {
        $return = self::select('users.*')
                        ->where('user_type', '=',5)
                        ->where('is_delete', '=',0);
        $return =$return ->orderBy('id', 'desc')
                        ->paginate(20);
        return   $return ;
    }
    static public function getAdmin()
    {
        $return = self::select('users.*')
                        ->where('user_type', '=',1)
                        ->where('is_delete', '=',0);
                        if(!empty(request()->get('name')))
                        {
                            $return =$return ->where('name', 'like','%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('email')))
                        {
                            $return =$return ->where('email', 'like','%'.request()->get('email').'%');
                        }
                        if(!empty(request()->get('date')))
                        {
                            $return =$return ->whereDate('created_at', '=', request()->get('date'));
                        }
        $return =$return ->orderBy('id', 'desc')
                        ->paginate(20);
        return   $return ;
    }

    static public function getTeacher($remove_pagination=0)
    {
        $return = self::select('users.*')
                        ->where('user_type', '=',2)
                        ->where('is_delete', '=',0);
                        if(!empty(request()->get('name')))
                        {
                            $return =$return ->where('users.name', 'like','%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('last_name')))
                        {
                            $return =$return ->where('users.last_name', 'like','%'.request()->get('last_name').'%');
                        }
                        if (!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email', 'like', '%'.request()->get('email').'%');
                        }
                        if(!empty(request()->get('marital_status')))
                        {
                            $return =$return ->where('users.marital_status', '=',request()->get('marital_status'));
                        }
                        if(!empty(request()->get('note')))
                        {
                            $return = $return->where('users.note', 'like', '%'.request()->get('note').'%');
                        }
                        if(!empty(request()->get('gender')))
                        {
                            $return =$return ->where('users.gender', '=', request()->get('gender'));
                        }
                        if(!empty(request()->get('qualification')))
                        {
                            $return =$return ->where('users.qualification', 'like','%'.request()->get('qualification').'%');
                        }
                        if(!empty(request()->get('phone_number')))
                        {
                            $return =$return ->where('users.phone_number', 'like','%'.request()->get('phone_number').'%');
                        }
                        if(!empty(request()->get('paddress')))
                        {
                            $return =$return ->where('users.paddress', 'like', '%'.request()->get('paddress').'%');
                        }
                        if(!empty(request()->get('address')))
                        {
                            $return =$return ->where('users.address', 'like', '%'.request()->get('address').'%');
                        }
                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') ==100)? 0 : 1; 
                            $return =$return ->where('users.status', '=', $status);
                        }
                        if(!empty(request()->get('admission_date')))
                        {
                            $return =$return ->whereDate('users.admission_date', '=', request()->get('admission_date'));
                        }
                        if(!empty(request()->get('date')))
                        {
                            $return =$return ->whereDate('users.created_at', '=', request()->get('date'));
                        }
        $return =$return ->orderBy('users.id', 'desc');
                        if(!empty($remove_pagination))
                        {
                            $return  = $return->get();
                        }
                        else
                        {
                            $return  = $return->paginate(20);
                        }
        return   $return ;
    }

    static public function getUser($user_type)
    {
        return self::select('users.*')
                    ->where('users.user_type', '=', $user_type)
                    ->where('users.is_delete', '=', 0)
                    ->get();
    }


    static public function getTeacherClass()
    {
        $return = self::select('users.*')
                        ->where('user_type', '=',2)
                        ->where('is_delete', '=',0);
        $return =$return ->orderBy('users.id', 'desc')
                        ->get();
        return   $return ;

    }

    
    static public function  getParent($remove_pagination=0)
    {
        $return = self::select('users.*')
                        ->where('user_type', '=', 4)
                        ->where('is_delete', '=',0);
                        if(!empty(request()->get('name')))
                        {
                            $return =$return ->where('users.name', 'like','%'.request()->get('name').'%');
                        }

                        if(!empty(request()->get('last_name')))
                        {
                            $return =$return ->where('users.last_name', 'like','%'.request()->get('last_name').'%');
                        }

                        if (!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email', 'like', '%'.request()->get('email').'%');
                        }

                        if(!empty(request()->get('occupation')))
                        {
                            $return =$return ->where('users.occupation', 'like','%'.request()->get('occupation').'%');
                        }

                        if(!empty(request()->get('address')))
                        {
                            $return =$return ->where('users.address', 'like','%'.request()->get('address').'%');
                        }

                        if(!empty(request()->get('gender')))
                        {
                            $return =$return ->where('users.gender', '=', request()->get('gender'));
                        }
        
                        if(!empty(request()->get('phone_number')))
                        {
                            $return =$return ->where('users.phone_number', 'like','%'.request()->get('phone_number').'%');
                        }
                        
                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') ==100)? 0 : 1; 
                            $return =$return ->where('users.status', '=', $status);
                        }
                       
                        if(!empty(request()->get('date')))
                        {
                            $return =$return ->whereDate('users.created_at', '=', request()->get('date'));
                        }
        $return =$return ->orderBy('id', 'desc');
                        if(!empty($remove_pagination))
                        {
                            $return  = $return->get();
                        }
                        else
                        {
                            $return  = $return->paginate(20);
                        }
                        return   $return ;
    }
    static public function getStudentclass($class_id)
    {
        return self::select('users.id', 'users.name', 'users.middle_name', 'users.last_name') 
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0)
                        ->where('users.class_id', '=', $class_id)
                         ->orderBy('users.id', 'desc')
                        ->get();
     
    }

    

    static public function getTeacherStudent($teacher_id)
    {
        $return = self::select('users.*', 'class.name as class_name')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
                        ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                        ->where('assign_class_teacher.status', '=',0)
                        ->where('assign_class_teacher.is_delete', '=',0)
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0);
        $return =$return ->orderBy('users.id', 'desc')
                        ->groupBy('users.id')
                        ->paginate(20);
        return   $return ;
    }

    static public function getTeacherStudentCount($teacher_id)
    {
        return  self::select('users.id')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->join('assign_class_teacher', 'assign_class_teacher.class_id', '=', 'class.id')
                        ->where('assign_class_teacher.teacher_id', '=', $teacher_id)
                        ->where('assign_class_teacher.status', '=',0)
                        ->where('assign_class_teacher.is_delete', '=',0)
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0)
                        ->orderBy('users.id', 'desc')
                        ->count();
      
    }
   
   

    static public function  getCollectFeesStudent()
    {
      
        $return = self::select('users.*', 'class.name as class_name', 'class.amount')
                        ->join('class', 'class.id', '=', 'users.class_id')
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0);
                        if(!empty(Request::get('class_id')))
                        {
                            $return =$return ->where('users.class_id', '=', Request::get('class_id'));
                            
                        } 
                        
                        if(!empty(Request::get('student_id')))
                        {
                            $return =$return ->where('users.id', '=', Request::get('student_id'));
                        } 
                        if(!empty(request()->get('first_name')))
                        {
                            $return =$return ->where('users.name', 'like','%'.request()->get('first_name').'%');
                        }

                        if(!empty(request()->get('last_name')))
                        {
                            $return =$return ->where('users.last_name', 'like','%'.request()->get('last_name').'%');
                        }
                       
        $return =$return ->orderBy('users.name', 'asc')
                        ->paginate(50);
        return   $return ;
    }

    static public function getStudent($remove_pagination = 0)
    {
        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name')
                        ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left') 
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0);
                        if(!empty(request()->get('name')))
                        {
                            $return =$return ->where('users.name', 'like','%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('last_name')))
                        {
                            $return =$return ->where('users.last_name', 'like','%'.request()->get('last_name').'%');
                        }
                        if (!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email', 'like', '%'.request()->get('email').'%');
                        }
                        if(!empty(request()->get('admission_number')))
                        {
                            $return =$return ->where('users.admission_number', 'like','%'.request()->get('admission_number').'%');
                        }
                        if(!empty(request()->get('roll_number')))
                        {
                            $return =$return ->where('users.roll_number', 'like','%'.request()->get('roll_number').'%');
                        }
                        if(!empty(request()->get('class')))
                        {
                            $return = $return->where('class.name', 'like', '%'.request()->get('class').'%');
                        }
                        if(!empty(request()->get('gender')))
                        {
                            $return =$return ->where('users.gender', '=', request()->get('gender'));
                        }
                        if(!empty(request()->get('religion')))
                        {
                            $return =$return ->where('users.religion', 'like','%'.request()->get('religion').'%');
                        }
                        if(!empty(request()->get('phone_number')))
                        {
                            $return =$return ->where('users.phone_number', 'like','%'.request()->get('phone_number').'%');
                        }
                        if(!empty(request()->get('blood_group')))
                        {
                            $return =$return ->where('users.blood_group', 'like', '%'.request()->get('blood_group').'%');
                        }
                        if(!empty(request()->get('status')))
                        {
                            $status = (request()->get('status') ==100)? 0 : 1; 
                            $return =$return ->where('users.status', '=', $status);
                        }
                        if(!empty(request()->get('admission_date')))
                        {
                            $return =$return ->whereDate('users.admission_date', '=', request()->get('admission_date'));
                        }
                        if(!empty(request()->get('date')))
                        {
                            $return =$return ->whereDate('users.created_at', '=', request()->get('date'));
                        }
        $return =$return ->orderBy('users.id', 'desc');
                        if(!empty($remove_pagination))
                         {
                             $return  = $return->get();
                        }
                         else
                        {
                             $return  = $return->paginate(20);
                         }
        return   $return ;
    }

    static public function getSearchStudent()
    {

        if(!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('last_name')) || !empty(Request::get('email')))
        {
            $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name', 'parent.last_name as parent_last_name' )  
                        ->join('users as parent', 'parent.id', '=', 'users.parent_id', 'left') 
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type', '=',3)
                        ->where('users.is_delete', '=',0);
                        if(!empty(request()->get('id')))
                        {
                            $return =$return ->where('users.id', '=', request()->get('id'));
                        }
                        if(!empty(request()->get('name')))
                        {
                            $return =$return ->where('users.name', 'like','%'.request()->get('name').'%');
                        }
                        if(!empty(request()->get('last_name')))
                        {
                            $return =$return ->where('users.last_name', 'like','%'.request()->get('last_name').'%');
                        }
                        if (!empty(request()->get('email')))
                        {
                            $return = $return->where('users.email', 'like', '%'.request()->get('email').'%');
                        }
                       
            $return =$return ->orderBy('users.id', 'desc')
                        ->limit(50)
                        ->get();
            return   $return ;
        }
    }

    static public function getMyStudent($parent_id)
    {
        $return = self::select('users.*', 'class.name as class_name', 'parent.name as parent_name')
                        ->join('users as parent', 'parent.id', '=', 'users.parent_id', ) 
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type', '=',3)
                        ->where('users.parent_id', '=', $parent_id)
                         ->orderBy('users.id', 'desc')
                        ->get();
        return   $return ;
        
    }

    static public function getMyStudentCount($parent_id)
    {
        $return = self::select('users.id')
                        ->join('users as parent', 'parent.id', '=', 'users.parent_id', ) 
                        ->join('class', 'class.id', '=', 'users.class_id', 'left')
                        ->where('users.user_type', '=',3)
                        ->where('users.parent_id', '=', $parent_id)
                        ->count();
        return   $return ;
        
    }
    
    static public function getPaidAmount($student_id, $class_id)
    {
        return StudentAddFeesModel::getPaidAmount($student_id, $class_id);
    }
    static public function getEmailSingle($email)
    {
        return User::where('email', '=',$email )->first();

    }

    
    static public function getTokenSingle($remember_token)

    {
        return User::where('remember_token', '=',$remember_token )->first();
    }

    public function getprofile()
    {
        if(!empty($this->profile_photo) && file_exists('upload/profile/'.$this->profile_photo))
        {
            return url('upload/profile/'.$this->profile_photo);
        }
        else
        {
            return  '';
        }
    } 

    public function getprofileDirect()
    {
        if(!empty($this->profile_photo) && file_exists('upload/profile/'.$this->profile_photo))
        {
            return url('upload/profile/'.$this->profile_photo);
        }
        else
        {
            return url('upload/profile/user.jpg');
        }
    } 

}
