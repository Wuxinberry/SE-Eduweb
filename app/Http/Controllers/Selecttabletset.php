<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use APP\Testtable;
use Symfony\Component\VarDumper\Cloner\Data;

// class Selecttabletset extends Controller
// {
//     public function index(){
//         $user = DB::select('select * from testtable where ss=?',[1]);
//         return $user;
//     }
// }
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers:Content-Type, Content-Length, Authorization, Accept, X-Requested-With , yourHeaderFeild,origin');
class Selecttabletset extends Controller
{

    public function index(){
        $data=['testnum'=>1,

        'testnum2'=>2,
        'testnum3'=>3
    ];
        
        return $data;
    }
    public function insertchooseques($choose_id,$couse_id,$teacher_id,$type,$stem,$value,$optionA,$optionB,$optionC,$optionD,$correct_answer){
         DB::table('Choose_questions')->insert([
            [

                'course_id'=>$couse_id,
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
        return "success";
    }

    public function modifychooseques($choose_id,$type,$stem,$value,$optionA,$optionB,$optionC,$optionD,$correct_answer){
    //     DB::table('Choose_questions')->where('choose_id' ,$choose_id)->update([
        //    [
        //        'type'=>$type,
        //        'stem'=>$stem,
        //        'value'=>$value,
        //        'optionA'=>$optionA,
        //        'optionB'=>$optionB,
        //        'optionC'=>$optionC,
        //        'optionD'=>$optionD,
        //        'correct_answer'=>$correct_answer
        //    ]
    //    ]);
    DB::update('update Choose_questions set type=:type,stem=:stem,value=:value,optionA=:A,optionB=:B,optionC=:C,optionD=:D,correct_answer=:ca where choose_id=:cid',[
        
        'cid'=>$choose_id,
        'type'=>$type,
        'stem'=>$stem,
        'value'=>$value,
        'A'=>$optionA,
        'B'=>$optionB,
        'C'=>$optionC,
        'D'=>$optionD,
        'ca'=>$correct_answer
    ]);
       return "success";
   }

    public function deletechooseques($choose_id){
        DB::delete('delete from Choose_questions where choose_id=:ci',['ci'=>$choose_id] );
        return "success";
    }

    public function showchoosequesbyid($choose_id=''){
        $choose_id="%".$choose_id."%";
        ini_set("error_reporting","E_ALL & ~E_NOTICE");
        $showall=DB::select('select * from Choose_questions where choose_id like :cid',['cid'=>$choose_id]);
        return $showall;
    }
    public function showchoosequesbycid($course_id=''){
        $course_id="%".$course_id."%";
        $showall=DB::select('select * from Choose_questions where course_id=:coi',['coi'=>$course_id] );
        return $showall;
    }

    public function insertJudgeques($judge_id,$couse_id,$teacher_id,$type,$stem,$value,$correct_answer){
        DB::table('Judge_questions')->insert([
           [
               'course_id'=>$couse_id,
               'teacher_id'=>$teacher_id,
               'type'=>$type,
               'stem'=>$stem,
               'value'=>$value,
               'correct_answer'=>$correct_answer
           ]
       ]);
       return "success";
   }

   public function modifyJudgeques($judge_id,$type,$stem,$value,$correct_answer){
   //     DB::table('Choose_questions')->where('choose_id' ,$choose_id)->update([
       //    [
       //        'type'=>$type,
       //        'stem'=>$stem,
       //        'value'=>$value,
       //        'optionA'=>$optionA,
       //        'optionB'=>$optionB,
       //        'optionC'=>$optionC,
       //        'optionD'=>$optionD,
       //        'correct_answer'=>$correct_answer
       //    ]
   //    ]);
   DB::update('update Judge_questions set type=:type,stem=:stem,value=:value,correct_answer=:ca where judge_id=:cid',[
       
       'cid'=>$judge_id,
       'type'=>$type,
       'stem'=>$stem,
       'value'=>$value,
       'ca'=>$correct_answer
   ]);
      return "success";
  }

  public function deleteJudgeques($judge_id){
   DB::delete('delete from Judge_questions where judge_id=:ci',['ci'=>$judge_id] );
  return "success";
   }

   public function showJudgequesbyid($judge_id=''){
       $judge_id="%".$judge_id."%";
      $showall=DB::select('select * from Judge_questions where judge_id like :cid',['cid'=>$judge_id]);
      return $showall;
   }
   public function showJudgequesbycid($course_id=''){
       $course_id="%".$course_id."%";
       $showall=DB::select('select * from Judge_questions where course_id=:coi',['coi'=>$course_id] );
       return $showall;
    }


    public function showtestpaperbyid($paper_id=''){
        $showall=DB::select('select * from Test_paper where paper_id=:coi',['coi'=>$paper_id] );
        return $showall;
     }
     public function showtestpaperbytid($teacher_id){
        $showall=DB::select('select * from Test_paper where teacher_id=:coi',['coi'=>$teacher_id] );
        return $showall;
     }
     public function inserttestpaper($paper_id,$paper_name,$couse_id,$teacher_id,$fullmark){
        
        DB::table('Test_paper')->insert([
           [
               'paper_name'=>$paper_name,
               'course_id'=>$couse_id,
               'teacher_id'=>$teacher_id,
               'fullmark'=>$fullmark
           ]
       ]);

       return DB::select('select max(paper_id) from Test_paper');

   }

   public function modifytestpaper($paper_id,$paper_name){
    DB::update('update Test_paper set paper_name=:paper_name where paper_id=:pid',[
        
        'pid'=>$paper_id,
        'paper_name'=>$paper_name
    ]);
       return "success";
   }
   public function deletetestpaper($paper_id){
    DB::delete('delete from Test_paper where paper_id=:pi',['pi'=>$paper_id] );
   return "success";
    }



    public function showtestpaperchoosequestionbyid($paper_id=''){
        $showall=DB::select('select choose_id from Test_paper_choose_question where paper_id=:coi',['coi'=>$paper_id] );
        return $showall;
     }

     public function inserttestpaperchoosequestion($paper_id,$choose_id){
        DB::table('Test_paper_choose_question')->insert([
           [
               'paper_id'=>$paper_id,
               'choose_id'=>$choose_id
           ]
       ]);
       return "success";
   }
   public function deletetestpaperchoosequestion($paper_id,$choose_id=''){
    if($choose_id==''){
        $choose_id='%'.$choose_id.'%';
    }
    DB::delete('delete from Test_paper_choose_question where paper_id=:pi and choose_id like :ci',['pi'=>$paper_id,'ci'=>$choose_id] );
   return "success";
    }


    public function showtestpaperjudgequestionbyid($paper_id=''){
        $showall=DB::select('select judge_id from Test_paper_judge_question where paper_id=:coi',['coi'=>$paper_id] );
        return $showall;
     }

     public function inserttestpaperjudgequestion($paper_id,$judge_id){
        DB::table('Test_paper_judge_question')->insert([
           [
               'paper_id'=>$paper_id,
               'judge_id'=>$judge_id
           ]
       ]);
       return "success";
   }
   public function deletetestpaperjudgequestion($paper_id,$judge_id=''){
        if($judge_id==''){
            $judge_id='%'.$judge_id.'%';
        }
        DB::delete('delete from Test_paper_judge_question where paper_id=:pi and judge_id like :ci',['pi'=>$paper_id,'ci'=>$judge_id] );
        return "success";
    }

    //* 自动生成试卷
    public function generatePaper($paper_name, $course_id, $teacher_id, $choose_num, $judge_num) {
        // 判断题目是否足够 不足返回0
        $choose_crt_num = DB::table('choose_questions')->where('course_id', $course_id)->count();
        if ( $choose_crt_num < $choose_num ) {
            return 0;
        }
        $judge_crt_num = DB::table('judge_questions')->where('course_id', $course_id)->count();
        if ( $judge_crt_num < $judge_num ) {
            return 0;
        }
        // 成功则返回试卷id
        // get judge questions randomly
        $rand_judge = $judge_num/$judge_crt_num + 0.1;
        $judge_ids = DB::raw('select judge_id from judge_questions where course_id = ? and RAND() <= ? limit ?',
            [$course_id, $rand_judge, $judge_num]);
        $rand_choose = $choose_num/$choose_crt_num + 0.1;
        $choose_ids = DB::raw('select choose_id from choose_questions where course_id = ? and RAND() <= ? limit ?',
            [$course_id, $rand_choose, $choose_num]);
        // 循环插入试卷
        DB::insert('insert into test_paper(course_id, teacher_id, $paper_name) values(?,?,?)', [$course_id, $teacher_id, $paper_name]);
        $paper_id = DB::raw('select max(paper_id) from test_paper');
        $fullmark = 0;
        foreach($judge_ids as $judge_id) {
            $fullmark += DB::table('judge_questions')->where('judge_id', $judge_id)->value('value');
            DB::insert('insert into test_paper_judge_question(paper_id, judge_id) values(?, ?)', [$paper_id, $judge_id]);
        }
        foreach($choose_ids as $choose_id) {
            $fullmark += DB::table('choose_questions')->where('choose_id', $choose_id)->value('value');
            DB::insert('insert into test_paper_choose_question(paper_id, choose_id) values(?, ?)', [$paper_id, $choose_id]);
        }
        DB::update('update test_paper set fullmark = ? where paper_id = ?', [$fullmark, $paper_id]);
        return $paper_id;
    }

    // * 增加查找函数
    // todo: 是不是头文件需要增加 为什么不能调用class里面的函数
    public function search($course_name) {
        // get course_ids
        $course_ids = DB::raw('select ID from course where name like ?', [$course_name]);
        foreach($course_ids as $course_id) {
            // show items
            showchoosequesbycid($course_id);
            showJudgequesbycid($course_id);
        }
    }
    // * 接收文件
    // public function scale_add($file) {
    //     return $file;
    // }


    public function edit_judge($judge_id, $stem, $value, $answer) {
        DB::raw('update judge_questions set stem=?, value=?, correcnt_answer=? where judge_id=?',
        [$stem, $value, $answer,$judge_id]);
    }
    public function edit_choose($choose_id, $stem, $value, $optionA, $optionB, $optionC, $optionD, $answer) {
        DB::raw('update choose_questions set stem=?, value=?, optionA=?, optionB=?, optionC=?, optionD=?, correcnt_answer=? where choose_id=?',
        [$stem, $value, $optionA, $optionB, $optionC, $optionD, $answer,$choose_id]);
    }


    public function search_judge($course_name) {
        // get course_ids
        $course_ids = DB::select('select ID from course where name like ? or ID like ?', [$course_name, $course_name]);
        $showall_judges = DB::select('select * from judge_questions where judge_id = :ji or stem like :ci', ['ji'=>$course_name, 'ci'=>$course_name]);
        foreach($course_ids as $course_id) {
             // show items
            $course_id="%".$course_id."%";
            $showall_judges += DB::select('select * from Judge_questions where course_id like :coi',['coi'=>$course_id] );
        }
        return $showall_judges;
    }
    public function search_choose($course_name) {
        // get course_ids
        $course_ids = DB::select('select ID from course where name like ? or ID like ?', [$course_name, $course_name]);
        $showall_chooses = DB::select('select * from choose_questions where choose_id = :ci or stem like :stem', ['ci'=>$course_name, 'stem'=>$course_name]);
        foreach($course_ids as $course_id) {
            // show items
            $course_id="%".$course_id."%";
            $showall_chooses += DB::select('select * from choose_questions where course_id=:coi',['coi'=>$course_id] );
        }
        
        return $showall_chooses;
    }
}