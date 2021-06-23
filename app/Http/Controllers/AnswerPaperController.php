<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnswerPaper;
use Illuminate\Support\Facades\DB;

class AnswerPaperController extends Controller
{
    /* ------ init: insert ------ */
    public function create($paper_id, $exam_id, $student_id) {
        DB::insert('insert into answer_paper_identity(paper_id, exam_id, student_id) values(?, ?, ?)',
         [$paper_id, $exam_id, $student_id]);

        return "succeed create answer paper {$paper_id} for student {$student_id} in exam {$exam_id}";
    }

    public function add_judge($paper_id, $judge_id, $student_id, $exam_id, $judge_answer, $score) {
        $insert = DB::insert('insert into answer_paper_judge(paper_id, exam_id, student_id, judge_id, judge_answer, result, score) values(?, ?, ?, ?, ?, ?, ?)',
        [$paper_id, $exam_id, $student_id, $judge_id, $judge_answer, 0, $score]);
        
        return "succeed to insert {$insert} record.";
    }

    public function add_choose($paper_id, $choose_id, $student_id, $exam_id, $choose_answer, $score) {
        $insert = DB::insert('insert into answer_paper_choose(paper_id, exam_id, student_id, choose_id, choose_answer, result, score) values(?, ?, ?, ?, ?, ?, ?)',
        [$paper_id, $exam_id, $student_id, $choose_id, $choose_answer, 0, $score]);

        return "succeed to insert {$insert} record.";
    }

    /* ------ compare answer ------ */
    public function judge_compare($paper_id, $judge_id, $student_id, $exam_id) {
        $judge_answer = DB::table('answer_paper_judge')
                        ->where('student_id', $student_id)
                        ->where('exam_id', $exam_id)
                        ->where('paper_id', $paper_id)
                        ->Where('judge_id', $judge_id)
                        ->value('judge_answer');
        $right_answer = DB::table('ques_judge')
                        ->where('judge_id', $judge_id)
                        ->value('right_answer');
        $score = DB::table('answer_paper_judge')
                    ->where('student_id', $student_id)
                   ->where('exam_id', $exam_id)
                    ->where('paper_id', $paper_id)
                    ->Where('judge_id', $judge_id)
                    ->value('score');
        // get current score of the paper
        $paper_score = DB::table('answer_paper_identity')
                    ->where('student_id', $student_id)
                    ->where('paper_id', $paper_id)
                    ->where('exam_id', $exam_id)
                    ->value('score'); 
        if ( $right_answer == $judge_answer ) {
            $result = 1;
        } else {
            $result = 0;
        }
        // store result of comparison
        DB::update('update answer_paper_judge set result=? where student_id=? and paper_id=? and exam_id=? and judge_id=?',
        [$result, $student_id,$paper_id, $judge_id ]);
        // update total score
        DB::update('update answer_paper_identity set score=? where student_id=? and exam_id=? and paper_id=?',
        [$score+$paper_score, $student_id, $exam_id, $paper_id]);

    }

    public function choose_compare($paper_id, $choose_id, $student_id, $exam_id) {
        $choose_answer = DB::table('answer_paper_choose')
                        ->where('student_id', $student_id)
                        ->where('exam_id', $exam_id)
                        ->where('paper_id', $paper_id)
                        ->Where('judge_id', $choose_id)
                        ->value('judge_answer');
        $right_answer = DB::table('ques_choose')
                        ->where('choose_id', $choose_id)
                        ->value('right_answer');
        $score = DB::table('answer_paper_choose')
                        ->where('student_id', $student_id)
                        ->where('exam_id', $exam_id)
                        ->where('paper_id', $paper_id)
                        ->Where('choose_id', $choose_id)
                        ->value('score');
        // get current score of the paper
        $paper_score = DB::table('answer_paper_identity')
                        ->where('student_id', $student_id)
                        ->where('paper_id', $paper_id)
                        ->where('exam_id', $exam_id)
                        ->value('score'); 
        if ( $right_answer == $choose_answer ) {
            $result = 1;
        } else {
            $result = 0;
        }
        // update result of comparison
        DB::update('update answer_paper_choose set result=? where student_id=? and paper_id=? and exam_id=? and choose_id=?',
        [$result, $student_id, $paper_id, $exam_id, $choose_id]);
        // upadte current score of the exam
        DB::update('update answer_paper_identity set score=? where student_id=? and exam_id=? and paper_id=?',
        [$score, $student_id, $exam_id, $paper_id]);
    }

}
