<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminContorller;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ExaminationsController;
use App\Http\Controllers\HomeWorkController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ClassSubjectController;
use App\Http\Controllers\ParentControllor;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentContorller;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AssignClassTeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassTimetableController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'Authlogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);



Route::group(['routeMiddleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/admin/list', [AdminContorller::class, 'list']);
    Route::get('admin/admin/add', [AdminContorller::class, 'add']);
    Route::post('admin/admin/add', [AdminContorller::class, 'insert']);
    Route::get('admin/admin/edit/{id}', [AdminContorller::class, 'edit']);
    Route::post('admin/admin/edit/{id}', [AdminContorller::class, 'update']);
    Route::get('admin/admin/delete/{id}', [AdminContorller::class, 'delete']);

    // teacher
    Route::get('admin/teacher/list', [TeacherController::class, 'list']);
    Route::get('admin/teacher/add', [TeacherController::class, 'add']);
    Route::post('admin/teacher/add', [TeacherController::class, 'insert']);
    Route::get('admin/teacher/edit/{id}', [TeacherController::class, 'edit']);
    Route::post('admin/teacher/edit/{id}', [TeacherController::class, 'update']);
    Route::get('admin/teacher/delete/{id}', [TeacherController::class, 'delete']);

    // student
    Route::get('admin/student/list', [StudentContorller::class, 'list']);
    Route::get('admin/student/add', [StudentContorller::class, 'add']);
    Route::post('admin/student/add', [StudentContorller::class, 'insert']);
    Route::get('admin/student/edit/{id}', [StudentContorller::class, 'edit']);
    Route::post('admin/student/edit/{id}', [StudentContorller::class, 'update']);
    Route::get('admin/student/delete/{id}', [StudentContorller::class, 'delete']);

    // parent
    Route::get('admin/parent/list', [ParentControllor::class, 'list']);
    Route::get('admin/parent/add', [ParentControllor::class, 'add']);
    Route::post('admin/parent/add', [ParentControllor::class, 'insert']);
    Route::get('admin/parent/edit/{id}', [ParentControllor::class, 'edit']);
    Route::post('admin/parent/edit/{id}', [ParentControllor::class, 'update']);
    Route::get('admin/parent/delete/{id}', [ParentControllor::class, 'delete']);
    Route::get('admin/parent/my-student/{id}', [ParentControllor::class, 'myStudent']);
    Route::get('admin/parent/assign_student_parent/{student_id}/{parent_id}', [ParentControllor::class, 'AssignStudentParent']);
    Route::get('admin/parent/assign_student_parent_delete/{student_id}', [ParentControllor::class, 'AssignStudentParentDelete']);

    // class url
    Route::get('admin/class/list', [ClassController::class, 'list']);
    Route::get('admin/class/add', [ClassController::class, 'add']);
    Route::post('admin/class/add', [ClassController::class, 'insert']);
    Route::get('admin/class/edit/{id}', [ClassController::class, 'edit']);
    Route::post('admin/class/edit/{id}', [ClassController::class, 'update']);
    Route::get('admin/class/delete/{id}', [ClassController::class, 'delete']);

    // subject url
    Route::get('admin/subject/list', [SubjectController::class, 'list']);
    Route::get('admin/subject/add', [SubjectController::class, 'add']);
    Route::post('admin/subject/add', [SubjectController::class, 'insert']);
    Route::get('admin/subject/edit/{id}', [SubjectController::class, 'edit']);
    Route::post('admin/subject/edit/{id}', [SubjectController::class, 'update']);
    Route::get('admin/subject/delete/{id}', [SubjectController::class, 'delete']);

    // assign_subject url
    Route::get('admin/assign_subject/list', [ClassSubjectController::class, 'list']);
    Route::get('admin/assign_subject/add', [ClassSubjectController::class, 'add']);
    Route::post('admin/assign_subject/add', [ClassSubjectController::class, 'insert']);
    Route::get('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'edit']);
    Route::post('admin/assign_subject/edit/{id}', [ClassSubjectController::class, 'update']);
    Route::get('admin/assign_subject/delete/{id}', [ClassSubjectController::class, 'delete']);
    Route::get('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'edit_single']);
    Route::post('admin/assign_subject/edit_single/{id}', [ClassSubjectController::class, 'update_single']);

    Route::get('admin/change_password', [UserController::class, 'change_password']);
    Route::post('admin/change_password', [UserController::class, 'update_change_password']);

    Route::get('admin/account', [UserController::class, 'MyAccount']);
    Route::post('admin/account', [UserController::class, 'UpdateMyAccountAdmin']);

    Route::get('admin/assign_class_teacher/list', [AssignClassTeacherController::class, 'list']);
    Route::get('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'add']);
    Route::post('admin/assign_class_teacher/add', [AssignClassTeacherController::class, 'insert']);
    Route::get('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'edit']);
    Route::post('admin/assign_class_teacher/edit/{id}', [AssignClassTeacherController::class, 'update']);
    Route::get('admin/assign_class_teacher/delete/{id}', [AssignClassTeacherController::class, 'delete']);
    Route::get('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'edit_single']);
    Route::post('admin/assign_class_teacher/edit_single/{id}', [AssignClassTeacherController::class, 'update_single']);

    Route::get('admin/class_timetable/list', [ClassTimetableController::class, 'list']);
    Route::post('admin/class_timetable/get_subject', [ClassTimetableController::class, 'get_subject']);
    Route::post('admin/class_timetable/add', [ClassTimetableController::class, 'insert_update']);

    Route::get('admin/examinations/exam/list', [ExaminationsController::class, 'exam_list']);
    Route::get('admin/examinations/exam/add', [ExaminationsController::class, 'exam_add']);
    Route::post('admin/examinations/exam/add', [ExaminationsController::class, 'exam_insert']);
    Route::get('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_edit']);
    Route::post('admin/examinations/exam/edit/{id}', [ExaminationsController::class, 'exam_update']);
    Route::get('admin/examinations/exam/delete/{id}', [ExaminationsController::class, 'exam_delete']);


    Route::get('admin/examinations/exam_schedule', [ExaminationsController::class, 'exam_schedule']);
    Route::post('admin/examinations/exam_schedule_insert', [ExaminationsController::class, 'exam_schedule_insert']);

    Route::get('admin/examinations/marks_register', [ExaminationsController::class, 'marks_register']);
    Route::post('admin/examinations/submit_makes_register', [ExaminationsController::class, 'submit_makes_register']);
    Route::post('admin/examinations/single_submit_makes_register', [ExaminationsController::class, 'single_submit_makes_register']);

    Route::get('admin/examinations/marks_grade/list', [ExaminationsController::class, 'marks_grade']);
    Route::get('admin/examinations/marks_grade/add', [ExaminationsController::class, 'mark_grade_add']);
    Route::post('admin/examinations/marks_grade/add', [ExaminationsController::class, 'mark_grade_insert']);
    Route::get('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'mark_grade_edit']);
    Route::post('admin/examinations/marks_grade/edit/{id}', [ExaminationsController::class, 'mark_grade_update']);
    Route::get('admin/examinations/marks_grade/delete/{id}', [ExaminationsController::class, 'mark_grade_delete']);

    Route::get('admin/attendance/student', [AttendanceController::class, 'AttendanceStudent']);
    Route::post('admin/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmid']);
    Route::get('admin/attendance/report', [AttendanceController::class, 'AttendanceReport']);


    Route::get('admin/communicate/notice_board/list', [CommunicateController::class, 'NoticeBoard']);
    Route::get('admin/communicate/notice_board/add', [CommunicateController::class, 'AddNoticeBoard']);
    Route::post('admin/communicate/notice_board/add', [CommunicateController::class, 'InsertNoticeBoard']);
    Route::get('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'EditNoticeBoard']);
    Route::post('admin/communicate/notice_board/edit/{id}', [CommunicateController::class, 'UpdateNoticeBoard']);
    Route::get('admin/communicate/notice_board/delete/{id}', [CommunicateController::class, 'DeleteNoticeBoard']);

    Route::get('admin/communicate/send_email', [CommunicateController::class, 'SendEmail']);
    Route::post('admin/communicate/send_email', [CommunicateController::class, 'SendEmailUser']);
    Route::get('admin/communicate/search_user', [CommunicateController::class, 'SearchUser']);

    Route::get('admin/homework/homework', [HomeWorkController::class, 'HomeWork']);
    Route::get('admin/homework/homework/add', [HomeWorkController::class, 'add']);
    Route::post('admin/homework/homework/add', [HomeWorkController::class, 'insert']);
    Route::get('admin/homework/homework/edit/{id}', [HomeWorkController::class, 'edit']);
    Route::post('admin/homework/homework/edit/{id}', [HomeWorkController::class, 'update']);
    Route::get('admin/homework/homework/delete/{id}', [HomeWorkController::class, 'delete']);
    Route::post('admin/ajax_get_subject', [HomeWorkController::class, 'get_ajax_subject']);
});

Route::group(['routeMiddleware' => 'teacher'], function () {
    Route::get('teacher/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('teacher/change_password', [UserController::class, 'change_password']);
    Route::post('teacher/change_password', [UserController::class, 'update_change_password']);

    Route::get('teacher/account', [UserController::class, 'MyAccount']);
    Route::post('teacher/account', [UserController::class, 'UpdateMyAccountTeacher']);

    Route::get('teacher/my_student', [StudentContorller::class, 'MyStudent']);
    Route::get('teacher/my_class_subject', [AssignClassTeacherController::class, 'MyClassSubject']);
    Route::get('teacher/my_class_subject/class_timetable/{class_id}/{subject_id}', [ClassTimetableController::class, 'MyTimetableTeacher']);

    Route::get('teacher/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetableTeacher']);

    Route::get('teacher/my_calendar', [CalendarController::class, 'MyCalendarTeacher']);
    Route::get('teacher/marks_register', [ExaminationsController::class, 'marks_register_teacher']);
    Route::post('teacher/submit_makes_register', [ExaminationsController::class, 'submit_makes_register']);
    Route::post('teacher/single_submit_makes_register', [ExaminationsController::class, 'single_submit_makes_register']);

    Route::get('teacher/attendance/student', [AttendanceController::class, 'AttendanceStudentTeacher']);
    Route::post('teacher/attendance/student/save', [AttendanceController::class, 'AttendanceStudentSubmid']);
    Route::get('teacher/attendance/report', [AttendanceController::class, 'AttendanceReportTeacher']);

    Route::get('teacher/my_notice_board', [CommunicateController::class, 'myNoticeBoardTeacher']);

    
    Route::get('teacher/homework/homework', [HomeWorkController::class, 'HomeWorkTeacher']);
    Route::get('teacher/homework/homework/add', [HomeWorkController::class, 'addTeacher']);
    Route::post('teacher/homework/homework/add', [HomeWorkController::class, 'insertTeacher']);
    Route::get('teacher/homework/homework/edit/{id}', [HomeWorkController::class, 'editTeacher']);
    Route::post('teacher/homework/homework/edit/{id}', [HomeWorkController::class, 'updateTeacher']);
    Route::get('teacher/homework/homework/delete/{id}', [HomeWorkController::class, 'deleteTeacher']);
    Route::post('teacher/ajax_get_subject', [HomeWorkController::class, 'get_ajax_subject_teacher']);
});

Route::group(['routeMiddleware' => 'student'], function () {
    Route::get('student/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('student/change_password', [UserController::class, 'change_password']);
    Route::post('student/change_password', [UserController::class, 'update_change_password']);

    Route::get('student/my_subject', [SubjectController::class, 'MySubject']);
    Route::get('student/my_timetable', [ClassTimetableController::class, 'MyTimeTable']);

    Route::get('student/my_exam_timetable', [ExaminationsController::class, 'MyExamTimetable']);

    Route::get('student/account', [UserController::class, 'MyAccount']);
    Route::post('student/account', [UserController::class, 'UpdateMyAccountStudent']);

    Route::get('student/my_calendar', [CalendarController::class, 'MyCalendar']);
    Route::get('student/my_exam_result', [ExaminationsController::class, 'myExamResult']);
    Route::get('student/my_attendance', [AttendanceController::class, 'myAttendance']);

    Route::get('student/my_notice_board', [CommunicateController::class, 'myNoticeBoardStudent']);
    Route::get('student/my_homework', [HomeWorkController::class, 'HomeWorkStudent']);

    Route::get('student/my_homework/submit_homework/{id}', [HomeWorkController::class, 'SubmitHomeWorkStudent']);
    Route::post('student/my_homework/submit_homework/{id}', [HomeWorkController::class, 'SubmitHomeWorkStudentInsert']);
});

Route::group(['routeMiddleware' => 'parent'], function () {
    Route::get('parent/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('parent/change_password', [UserController::class, 'change_password']);
    Route::post('parent/change_password', [UserController::class, 'update_change_password']);

    Route::get('parent/account', [UserController::class, 'MyAccount']);
    Route::post('parent/account', [UserController::class, 'UpdateMyAccountParent']);

    Route::get('parent/my_student_subject/{student_id}', [SubjectController::class, 'ParentStudentSubject']);

    Route::get('parent/my_student/subject/class_timetable/{class_id}/{subject_id}/{student_id}', [ClassTimetableController::class, 'MyTimeTableParent']);

    Route::get('parent/my_student', [ParentControllor::class, 'myStudentParent']);
    Route::get('parent/exam_timetable/{student_id}', [ExaminationsController::class, 'MyExamTimetableParent']);

    Route::get('parent/my_student/calendar/{student_id}', [CalendarController::class, 'myCalenderParent']);
    Route::get('parent/exam_result/{student_id}', [ExaminationsController::class, 'myExamResultParent']);
    Route::get('parent/my_student/attendance/{student_id}', [AttendanceController::class, 'AttendanceStudentParent']);


    Route::get('parent/my_notice_board', [CommunicateController::class, 'myNoticeBoardParent']);
});
