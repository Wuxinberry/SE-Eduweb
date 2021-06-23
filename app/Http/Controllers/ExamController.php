<?php

namespace App\Http\Controllers;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function create($exam_id, $paper_id, $course_id, $student_id, $start_time, $end_time, $state, $score) {
        
        DB::insert('insert into exam(exam_id, paper_id, course_id, student_id, start_time, end_time, state, score) values(?, ?, ?, ?, ?, ?, ?, ?)'
            ,[$exam_id, $paper_id, $course_id, $student_id, $start_time, $end_time, $state, $score]);
         return "succeed to insert!";
    }

    public function delete($exam_id) {
        DB::delete('delete from exam where exam_id = ?', [$exam_id]);
        return "succeed to delete exam: {$exam_id}";
    }

    public function edit($exam_id, $paper_id, $course_id, $student_id, $start_time, $end_time, $state, $score) {
        $update = DB::update('update exam set exam_id=?, paper_id=?, course_id=?, student_id=?, start_time=?, end_time=?, state=?, score=? where exam_id=?'
        ,[$exam_id, $paper_id, $course_id, $student_id, $start_time, $end_time, $state, $score, $exam_id]);
        return "update {$update} exam";
    }

    public function query($exam_id) {
        $select = DB::select('select * from exam where exam_id = ?', [$exam_id]);
        return $select;
    }
}
