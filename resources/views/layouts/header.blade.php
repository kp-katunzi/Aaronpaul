
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
            <a href="{{ url('logout')}}" class="nav-link">
              <i class="fas fa-power-off"></i>
                Logout
            </a>
          </li>     
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:;" class="brand-link" style="text-align: center;">
      @if(!empty($getHeaderSetting->getLogo()))
      <img src="{{$getHeaderSetting->getLogo() }}"  style="width:auto; height: 75px; border-radius: 5px;">
      @else
      <span class="brand-text font-weight-light font-weight:bold !important;font-size:20px;">CMS</span>
      @endif
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
          <img style="height: 40px; width: 40px;" src="{{Auth::user()->getprofileDirect() }}" class="img-circle elevation-2" alt="{{Auth::user()->name}}">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>
      <nav class="mt-2" >
        <ul class="nav nav-pills nav-sidebar flex-column" style="overflow: auto;" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->user_type == 1)
            <li class="nav-item">
              <a href="{{ url('admin/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard   {{ Request::segment(2) }}
                </p>
              </a>
            </li>
            <li class="nav-item">
            <a href="{{ url('admin/admin/list')}}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Admin
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/teacher/list')}}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
              <i class="fas fa-chalkboard-teacher"></i>
              <p>
                Teacher
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/student/list')}}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
              <i class="fas fa-user-graduate"></i>
              <p>
                Student
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/parent/list')}}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Parent
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/accountant/list')}}" class="nav-link @if(Request::segment(2) == 'accountant') active @endif">
              <i class="fas fa-chalkboard-teacher"></i>
              <p>
                Accountant
              </p>
            </a>
          </li>
          <li class="nav-item  @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject'
          || Request::segment(2) == 'class_timetable' || Request::segment(2) == 'assign_class_teacher' ) menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' ||
          Request::segment(2) == 'class_timetable' || Request::segment(2) == 'assign_class_teacher' ) active @endif">
              <i class="fas fa-graduation-cap"></i>
              <p>
                Academics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/class/list')}}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Class</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/subject/list')}}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Subject</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/assign_subject/list')}}" class="nav-link @if(Request::segment(2) == 'assign_subject') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>  Assign Subject</p>
                </a>
              </li>     
              <li class="nav-item">
                <a href="{{ url('admin/class_timetable/list')}}" class="nav-link @if(Request::segment(2) == 'class_timetable') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Class Timetable</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="{{ url('admin/assign_class_teacher/list')}}" class="nav-link @if(Request::segment(2) == 'assign_class_teacher') active @endif">
                <i class="fas fa-book-open"></i>
                  <p> Assign Class Teacher</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item  @if(Request::segment(2) == 'fees_collection') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'fees_collection') active @endif">
            <i class="fas fa-stamp"></i>
              <p>
              Fees Collection
              <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/fees_collection/collect_fees')}}" class="nav-link @if(Request::segment(3) == 'collect_fees') active @endif">
                  <i class="far fa-money-bill-alt"></i>
                  <p>Collect Fees</p>
                </a>
              </li>
             </ul>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/fees_collection/collect_fees_report')}}" class="nav-link @if(Request::segment(3) == 'collect_fees_report') active @endif">
                  <i class="far fa-money-bill-alt"></i>
                  <p>Collect Fees Report</p>
                </a>
              </li> 
             </ul>
             
          </li>
          <li class="nav-item  @if(Request::segment(2) == 'examinations') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'examinations') active @endif">
            <i class="fas fa-book-open"></i>
              <p>
                Examinations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/examinations/exam/list')}}" class="nav-link @if(Request::segment(3) == 'exam') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Exam</p>
                </a>
              </li>    
              <li class="nav-item">
                <a href="{{ url('admin/examinations/exam_schedule')}}" class="nav-link @if(Request::segment(3) == 'exam_schedule') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Exam Schedule</p>
                </a>
              </li>   
              <li class="nav-item">
                <a href="{{ url('admin/examinations/marks_register')}}" class="nav-link @if(Request::segment(3) == 'marks_register') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Marks Register</p>
                </a>
              </li>  
              <li class="nav-item">
                <a href="{{ url('admin/examinations/marks_grade')}}" class="nav-link @if(Request::segment(3) == 'marks_grade') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>Marks Grade</p>
                </a>
              </li> 
            </ul>
          </li>   

          <li class="nav-item  @if(Request::segment(2) == 'communicate') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'communicate') active @endif">
              <i class="fas fa-phone-volume"></i>
              <p>
                Communicate
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/communicate/notice_board')}}" class="nav-link @if(Request::segment(3) == 'notice_board') active @endif">
                <i class="nav-icon fas fa-columns"></i>
                  <p>Notice Board</p>
                </a>
              </li> 
             </ul>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/communicate/send_email')}}" class="nav-link @if(Request::segment(3) == 'send_email') active @endif">
                 <i class="nav-icon far fa-envelope"></i>
                  <p>Send Email</p>
                </a>
              </li>       
            </ul>
          </li>   

          <li class="nav-item  @if(Request::segment(2) == 'User_Management') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == ' User_Management') active @endif">
              <i class="far fa-address-book"></i>
              <p>
                User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/User_Management/view_users')}}" class="nav-link @if(Request::segment(3) == 'view_users') active @endif">
                <i class="nav-icon fas fa-eye"></i>
                  <p>View Users</p>
                </a>
              </li> 
             </ul>
             <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/User_Management/Users')}}" class="nav-link @if(Request::segment(3) == 'Users') active @endif">
                 <i class="nav-icon far fa-user"></i>
                  <p>Users</p>
                </a>
              </li>       
            </ul>
          </li>   
          
          
          <li class="nav-item">
              <a href="{{ url('admin/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                <i class="nav-icon far fa-user"></i>
                <p>
                  My Account
                </p>
              </a>
          </li>  
          <li class="nav-item">
              <a href="{{ url('admin/setting')}}" class="nav-link @if(Request::segment(2) == 'setting') active @endif">
                <i class="fa fa-cog" aria-hidden="true"></i>
                <p>
                  Setting
                </p>
              </a>
          </li> 
          <li class="nav-item">
            <a href="{{ url('admin/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
            <i class="fas fa-key"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>        
          @elseif(Auth::user()->user_type == 2)
            <li class="nav-item">
              <a href="{{ url('teacher/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ url('teacher/my_student')}}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="fas fa-user-graduate"></i>
                <p>
                  Student
                </p>
              </a>
            </li>               
          <li class="nav-item  @if(Request::segment(2) == 'my_class_subject' || Request::segment(2) == 'my_exam_timetable' || 
          Request::segment(2) == 'marks_register') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'my_class_subject' || Request::segment(2) == 'my_exam_timetable' ||
             Request::segment(2) == 'marks_register' ) active @endif">
              <i class="fas fa-graduation-cap"></i>
              <p>
                Academics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('teacher/my_class_subject')}}" class="nav-link @if(Request::segment(2) == 'my_class_subject') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>My Class & Subject</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('teacher/my_exam_timetable')}}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                    Exam Timetable
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('teacher/marks_register')}}" class="nav-link @if(Request::segment(2) == 'marks_register') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                       Marks Register
                    </p>
                </a>
              </li>
            </ul>
          </li>   
              <li class="nav-item">
                <a href="{{ url('teacher/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
                <i class="nav-icon fas fa-columns"></i>
                  <p>
                    Notice Board
                  </p>
                </a>
              </li>

            <!-- <li class="nav-item">
              <a href="{{ url('teacher/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                <i class="nav-icon far fa-user"></i>
                <p>
                  My Account
                </p>
              </a>
          </li> -->
            <li class="nav-item">
            <a href="{{ url('teacher/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
            <i class="fas fa-key"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
          @elseif(Auth::user()->user_type == 3)
            <li class="nav-item">
                <a href="{{ url('student/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>                        
          <li class="nav-item  @if(Request::segment(2) == 'my_subject' || Request::segment(2) == 'my_timetable' || 
          Request::segment(2) == 'marks_register' || Request::segment(2) == 'my_exam_result') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link  @if(Request::segment(2) == 'my_subject' || Request::segment(2) == 'my_timetable' ||
             Request::segment(2) == 'my_exam_timetable' || Request::segment(2) == 'my_exam_result' ) active @endif">
              <i class="fas fa-graduation-cap"></i>
              <p>
                Academics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('student/my_subject')}}" class="nav-link @if(Request::segment(2) == 'my_subject') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                     Subject
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('student/my_timetable')}}" class="nav-link @if(Request::segment(2) == 'my_timetable') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                     Timetable
                  </p>
                </a>
              </li>
  
              <li class="nav-item">
                <a href="{{ url('student/my_exam_timetable')}}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                       Exam Timetable
                    </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('student/my_exam_result')}}" class="nav-link @if(Request::segment(2) == 'my_exam_result') active @endif">
                <i class="fas fa-book-open"></i>
                  <p>
                    Result
                    </p>
                </a>
              </li>
            </ul>
          </li>
              <li class="nav-item">
                <a href="{{ url('student/fees_collection')}}" class="nav-link @if(Request::segment(2) == 'fees_collection') active @endif">
                <i class="fas fa-stamp"></i>
                  <p>
                     Fees Collection
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('student/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
                <i class="nav-icon fas fa-columns"></i>
                  <p>
                    Notice Board
                  </p>
                </a>
              </li>
<!-- 
              <li class="nav-item">
                <a href="{{ url('student/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                  <i class="nav-icon far fa-user"></i>
                  <p>
                    My Account
                  </p>
                </a>
              </li> -->

              <li class="nav-item">
                <a href="{{ url('student/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
                <i class="fas fa-key"></i>
                  <p>
                    Change Password
                  </p>
                </a>
              </li>
          @elseif(Auth::user()->user_type == 4)
            <li class="nav-item">
                <a href="{{ url('parent/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                   <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('parent/my_student')}}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
                <i class="fas fa-user-graduate"></i>
                  <p>
                    My Student
                  </p>
                </a>
             </li>
             <li class="nav-item">
                <a href="{{ url('parent/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
                <i class="nav-icon fas fa-columns"></i>
                  <p>
                    Notice Board
                  </p>
                </a>
              </li>
<!-- 
            <li class="nav-item">
                <a href="{{ url('parent/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                  <i class="nav-icon far fa-user"></i>
                  <p>
                    My Account
                  </p>
                </a>
              </li> -->

            <li class="nav-item">
             <a href="{{ url('parent/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="fas fa-key"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          @elseif(Auth::user()->user_type == 5)
            <li class="nav-item">
                <a href="{{ url('account/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                   <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('account/accountant')}}" class="nav-link @if(Request::segment(2) == 'accountant') active @endif">
                <i class="fas fa-user-graduate"></i>
                  <p>
                    Accountant
                  </p>
                </a>
            </li>
          
          @endif    
        </ul>
      </nav>
    </div>
  </aside>
