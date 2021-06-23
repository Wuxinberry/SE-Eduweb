<?php
use App\Models\Exam;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
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
Route::get('/exam/create/{exam_id}/{paper_id}/{course_id}/{student_id}/{start_time}/{end_time}/{state}/{score}', [ExamController::class, 'create']);

Route::get('exam/delete/{exam_id}', [ExamController::class, 'delete']);

Route::get('exam/edit/{exam_id}/{paper_id}/{course_id}/{student_id}/{start_time}/{end_time}/{state}/{score}', [ExamController::class, 'edit']);

Route::get('exam/query/{exam_id}', [ExamController::class, 'query']);


