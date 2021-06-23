<?php

namespace Database\Factories;

use App\Models\ques_choice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class QuesChoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ques_choice::class;

    /**
     * Define the model's default state.
     *  
     * @return array
     */
    public function definition()
    {
        return [

            'stem' => $this->faker->paragraph(3, true),
            'option_a' => $this->faker->sentence(5, true),
            'option_b' => $this->faker->sentence(5, true),
            'option_c' => $this->faker->sentence(5, true),
            'option_d' => $this->faker->sentence(5, true),
            'right_answer' => $this->faker->randomElements(['A', 'B', 'C', 'D'], 1),
            'teacher_name' => $this->faker->name(),
            'course_name' => $this->faker->randomElements(['高级数据结构', '软件工程基础', '计算机系统原理', '军事理论'], 1),
            'knowledge_pnt' => $this->faker->text(),
            'score' => $this->faker->randomDigit,
            'created_at' => $this->faker->dateTimeBetween('-3 year', '-1 year'),// 时间在 三年到一年 之间
            'updated_at' => $this->faker->dateTimeBetween('-1 year', '-5 month'),// 时间在 一年到五个月之间
        ];
    }
}
