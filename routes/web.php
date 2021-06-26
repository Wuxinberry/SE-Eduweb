<?php
use App\Models\Exam;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FileUploadController;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// useful command
// php artisan route:list
// php artisan route:cache
// composer du 
Route::get('/',  function() {
    return view('welcome');
});

Route::get('foo', function() {
    return "test";
});
// testing
// exam/create/352786/001003/001004/3190105547/2021-6-30%2018:30:00/2021-6-30%2020:30:00/未开始/100
Route::get('/exam/create/{paper_id}/{course_id}/{teacher_id}/{start_time}/{end_time}/{state}', [ExamController::class, 'create']);

Route::get('exam/delete/{exam_id}', [ExamController::class, 'delete']);

Route::get('exam/edit/{exam_id}/{paper_id}/{course_id}/{student_id}/{start_time}/{end_time}/{state}/{score}', [ExamController::class, 'edit']);

Route::get('exam/query/{exam_id}', [ExamController::class, 'query']);

Route::get('/stu', 'Selecttabletset@index');

Route::get('/edit/choose/{choose_id}/{stem}/{value}/{optionA}/{optionB}/{optionC}/{optionD}/{answer}', 'Selecttabletset@edit_choose');
Route::get('/edit/judge/{judge_id}/{stem}/{value}/{answer}', 'Selecttabletset@edit_judge');

Route::get('/scale_add_judge/{course_id}/{teacher_id}/{type}/{stem}/{value}/{correct_answer}', [FileUploadController::class, 'scale_add_judge']);
Route::get('/scale_add_choose/{course_id}/{teacher_id}/{type}/{stem}/{value}/{optionA}/{optionB}/{optionC}/{optionD}/{correct_answer}', [FileUploadController::class, 'scale_add_choose']);

Route::get('/generatePaper/{paper_name}/{course_id}/{teacher_id}/{choose_num}/{judge_num}', 'Selecttabletset@generatePaper');

Route::get('/Selecttableset/{file}', 'Selecttableset@scale_add');

Route::get('/search/{course_name}', 'Selecttabletset@search');

Route::get('/show_choose_questionbyid/{choose_id?}','Selecttabletset@showchoosequesbyid');
Route::get('/show_choose_questionbycid/{course_id?}','Selecttabletset@showchoosequesbycid');
Route::get('/add_choose_question/{choose_id}/{couse_id}/{teacher_id}/{type}/{stem}/{value}/{optionA}/{optionB}/{optionC}/{optionD}/{correct_answer}', 'Selecttabletset@insertchooseques' );
Route::get('/modify_choose_question/{choose_id}/{type}/{stem}/{value}/{optionA}/{optionB}/{optionC}/{optionD}/{correct_answer}', 'Selecttabletset@modifychooseques' );
Route::get('/delete_choose_question/{choose_id}','Selecttabletset@deletechooseques' );


Route::get('/show_judge_questionbyid/{judge_id?}','Selecttabletset@showjudgequesbyid');
Route::get('/show_judge_questionbycid/{judge_id?}','Selecttabletset@showjudgequesbycid');
Route::get('/add_judge_question/{judge_id}/{couse_id}/{teacher_id}/{type}/{stem}/{value}/{correct_answer}', 'Selecttabletset@insertjudgeques' );
Route::get('/modify_judge_question/{judge_id}/{type}/{stem}/{value}/{correct_answer}', 'Selecttabletset@modifyjudgeques' );
Route::get('/delete_judge_question/{judge_id}','Selecttabletset@deletejudgeques' );

Route::get('/show_test_paperbyid/{paper_id}','Selecttabletset@showtestpaperbyid');
Route::get('/add_test_paper/{paper_id}/{paper_name}/{couse_id}/{teacher_id}/{full_mark}', 'Selecttabletset@inserttestpaper' );
Route::get('/modify_test_paper/{paper_id}/{paper_name}', 'Selecttabletset@modifytestpaper' );
Route::get('/delete_test_paper/{paper_id}','Selecttabletset@deletetestpaper' );

Route::get('/show_test_paper_choose_questionbyid/{paper_id}','Selecttabletset@showtestpaperchoosequestionbyid');
Route::get('/add_test_paper_choose_question/{paper_id}/{choose_id}', 'Selecttabletset@inserttestpaperchoosequestion' );
Route::get('/delete_test_paper_choose_question/{paper_id}/{choose_id?}','Selecttabletset@deletetestpaperchoosequestion' );

Route::get('/show_test_paper_judge_questionbyid/{paper_id}','Selecttabletset@showtestpaperjudgequestionbyid');
Route::get('/add_test_paper_judge_question/{paper_id}/{choose_id}', 'Selecttabletset@inserttestpaperjudgequestion' );
Route::get('/delete_test_paper_judge_question/{paper_id}/{choose_id?}','Selecttabletset@deletetestpaperjudgequestion' );

Route::get('/count');
