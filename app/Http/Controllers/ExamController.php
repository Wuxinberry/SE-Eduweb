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
    public function queryexamstu($stu_id) {
        $select = DB::select('select exam_id from Exam_student where student_id = ?', [$stu_id]);
        return $select;
    }
    public function queryexamtea($tea_id) {
        $select = DB::select('select * from Exam_identity where teacher_id = ?', [$tea_id]);
        return $select;
    }
    public function modifyexamstate($exam_id){
        DB::update('update Exam_identity set state=:paper_name where exam_id=:pid',[
            
            'pid'=>$exam_id,
            'paper_name'=>'已结束'
        ]);
           return "success";
    }
    public function update() {

        $crt_time = date("Y-m-d H:i:s", time());
        $exam_ids = DB::table('exam_identity')->pluck('exam_id');
        
        foreach($exam_ids as $exam_id) {
            $crt_state = DB::table('exam_identity')->where('exam_id', $exam_id)->value('state');
            if ( $crt_state == '已结束' ) {
                continue;
            }
            $start_time = DB::table('exam_identity')->where('exam_id', $exam_id)->value('start_time');
            $end_time = DB::table('exam_identity')->where('exam_id', $exam_id)->value('end_time');
            if ( $crt_time > $start_time && $crt_time < $end_time ) {
                DB::update('update exam_identity set state=? where exam_id=?', ['进行中', $exam_id]);
            } else if ( $crt_time > $end_time ) {
                DB::update('update exam_identity set state=? where exam_id=?', ['已结束', $exam_id]);
            } else if ( $crt_time < $start_time ) {
                DB::update('update exam_identity set state=? where exam_id=?', ['未开始', $exam_id]);
            }
        }

        return $crt_time;
    }



    

}
