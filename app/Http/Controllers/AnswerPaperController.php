<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnswerPaper;
use Illuminate\Support\Facades\DB;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');

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
    /* ------------------- 试卷批改 --------------------- */
    /* ------ calculate score ------ */
    public function score_calculate($exam_id, $student_id) {
        $score_judge = DB::table('answer_paper_judge')
                ->where('exam_id', $exam_id)->where('student_id', $student_id)
                ->value('score');
        $score_choose = DB::table('answer_paper_choose')
                ->where('exam_id', $exam_id)->where('student_id', $student_id)
                ->value('score');
        DB::table('answer_paper_identity')->where('exam_id', $exam_id)->where('student_id', $student_id)
            ->update(['score' => $score_judge + $score_choose]);
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

    /*-----------------成绩分析-----------------*/
    /* ----- 统计错误率 ----- */
        // todo: testing on real data
        // * result structure
        // * result = [
        // * 'judge': [
        // *   'judge_id': correct-ratio,
        // *    ......  
        // *  ],
        // * 'choose': [
        // *   'choose_id': correct-ratio,    
        // *    ......
        // *  ]
        // * ]
    function CorrectForEachPage($exam_id) {
        // select all students participated the exam
        $students = DB::table('exam_student')->where('exam_id', $exam_id)->pluck('student_id');
        $cnt_total = DB::table('exam_student')->where('exam_id', $exam_id)->count();
        $paper_id = DB::table('exam_identity')->where('exam_id', $exam_id)->value('paper_id');
        // store result into an array
        $judge_result = array();  // judge_id=>correctness
        $choose_result = array(); // choose_id=>correctness 
        // select questions
        $judge_ids = DB::table('test_paper_judge_question')->where('paper_id', $paper_id)->plunk('judge_id');
        $choose_ids = DB::table('test_paper_choose_question')->where('paper_id', $paper_id)->plunk('choose_id');
        // loop to get correctness ratio
        foreach($judge_ids as $judge_id) {
            $cnt_correct = 0;
            foreach($students as $student_id) {
                $answer = DB::table('answer_paper_judge')
                        ->where('exam_id', $exam_id)->where('student_id', $student_id)->where('judge_id', $judge_id)
                        ->value('result');
                if ( $answer == 1) {
                    $cnt_correct++;
                }
            }
            $tmp_ratio = $cnt_correct/$cnt_total;
            $judge_result[$judge_id]=$tmp_ratio;
        }
        foreach($choose_ids as $choose_id) {
            $cnt_correct = 0;
            foreach($students as $student_id) {
                $answer = DB::table('answer_paper_choose')
                        ->where('exam_id', $exam_id)->where('student_id', $student_id)->where('choose_id', $choose_id)
                        ->value('result');
                if ( $answer == 1) {
                    $cnt_correct++;
                }
            }
            $tmp_ratio = $cnt_correct/$cnt_total;
            $choose_result[$choose_id]=$tmp_ratio;
        }
        $result = array();
        $result['judge'] = $judge_result;
        $result['choose'] = $choose_result;

        return $result;
    }
    /* ----- 单次考试 学生成绩排名 ----- */
    function RankForEachExam($exam_id) {
        DB::table('answer_paper_identity')->where('$exam_id', $exam_id)
        ->DB::raw('select score RANK() OVER (order by score DESC)rank');
    }
}
