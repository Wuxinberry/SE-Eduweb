<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');


// class ScoreAnalysisController extends Controller
// {
//     public function get_scores($student_id) {
//         // exam_id, student_id, course_name, score
//         $exam_ids = DB::table('exam_identity')->pluck('student_id');
//         $score_results = [];
//         foreach($exam_ids as $exam_id) {

//         }

//     }
// }
