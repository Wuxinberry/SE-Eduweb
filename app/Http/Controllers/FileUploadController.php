<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');

class FileUpload extends Controller
{
    public function scale_add_judge($course_id, $teacher_id, $type, $stem, $value, $correct_answer) {
        DB::table('Judge_questions')->insert([
            [
                'course_id'=>$course_id,
                'teacher_id'=>$teacher_id,
                'type'=>$type,
                'stem'=>$stem,
                'value'=>$value,
                'correct_answer'=>$correct_answer
            ]
        ]);
    }

    public function scale_add_choose($course_id, $teacher_id, $type, $stem, $value, $optionA, $optionB, $optionC, $optionD, $correct_answer) {
        DB::table('choose_questions')->insert([
            [
                'course_id'=>$course_id,
                'teacher_id'=>$teacher_id,
                'type'=>$type,
                'stem'=>$stem,
                'value'=>$value,
                'optionA'=>$optionA,
                'optionB'=>$optionB,
                'optionC'=>$optionC,
                'optionD'=>$optionD,
                'correct_answer'=>$correct_answer
            ]
        ]);
    }
}
