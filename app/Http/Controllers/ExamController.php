<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\countOf;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');
class ExamController extends Controller
{
    public function create($paper_id, $course_id, $teacher_id, $start_time, $end_time, $state) {
        $fullmark = DB::table('test_paper')
                    ->where('paper_id',$paper_id)
                    ->value('fullmark');

        $insert = 0;
        $insert += DB::insert('insert into exam_identity(paper_id, course_id, teacher_id, start_time, end_time, state, fullmark, publish) values( ?, ?, ?, ?, ?, ?, ?, ?)'
                 ,[$paper_id, $course_id, $teacher_id, $start_time, $end_time, $state, $fullmark, 0]);

        $exam_id = DB::table('exam_identity')->where("paper_id", $paper_id)
                    ->where('course_id', $course_id)->where('start_time', $start_time)->value('exam_id');
        $students = DB::table('course_select')->where("Course_id", $course_id)->pluck('Student_id');
        foreach ($students as $student) {
            $insert += DB::insert('insert into exam_student(exam_id, student_id) values( ?, ?)'
                 ,[$exam_id, $student]);
        }
    }

    public function delete($exam_id) {
        DB::delete('delete from exam where exam_id = ?', [$exam_id]);
        return "succeed to delete exam: {$exam_id}";
    }

    public function edit($exam_id, $state, $publish) {
        $update = DB::update('update exam_identity set state=?, publish=? where exam_id=?'
        ,[$state, $publish, $exam_id]);
        return "update {$update} exam";
    }

    public function query($exam_id) {
        $select = DB::select('select * from exam_identity where exam_id = ?', [$exam_id]);
        return $select;
    }
}
