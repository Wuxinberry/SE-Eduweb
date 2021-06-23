<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerPaperJudgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_paper_judge', function (Blueprint $table) {
            $table->bigInteger('paper_id');
            $table->bigInteger('exam_id');
            $table->bigInteger('student_id');
            $table->bigInteger('judge_id');
            $table->char('judge_answer');
            $table->integer('result');
            $table->integer('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_paper_judge');
    }
}
