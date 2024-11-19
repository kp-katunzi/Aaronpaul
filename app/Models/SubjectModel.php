<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;
    
    protected $table = 'subject';

    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = SubjectModel::select('subject.*', 'users.name as created_by_name')
                    ->join('users', 'users.id', 'subject.created_by');
                    if(!empty(request()->get('name')))
                    {
                        $return = $return->where('subject.name', 'like', '%'.request()->get('name').'%');
                    }
                    if(!empty(request()->get('type')))
                    {
                        $return = $return->where('subject.type', '=', request()->get('type'));
                    }
                    if(!empty(request()->get('date')))
                    {
                        $return =$return ->whereDate('subject.created_at', '=', request()->get('date'));
                    }
                    $return = $return->where('subject.is_delete', '=', 0)
                    ->orderBy('subject.id', 'desc')
                    ->paginate(20);
                    
      return   $return;
    }

    static public function getSubject()
    {
        $return = SubjectModel::select('subject.*')
                    ->join('users', 'users.id', 'subject.created_by')
                    ->where('subject.is_delete', '=', 0)
                    ->where('subject.status', '=', 0)
                    ->orderBy('subject.name', 'asc')
                    ->get();
                    
        return   $return;
    }

    static public function getTotalSubject()
    {
        $return = SubjectModel::select('subject.ID')
                    ->join('users', 'users.id', 'subject.created_by')
                    ->where('subject.is_delete', '=', 0)
                    ->where('subject.status', '=', 0)
                    ->count();
                    
        return   $return;
    }
}
