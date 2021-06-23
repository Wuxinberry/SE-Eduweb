<?php

namespace Database\Seeders;
use APP\Models\QuesChoice;
use Illuminate\Database\Seeder;

class QuesChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuesChoice::factory()
            ->times(50)
            ->hasPosts(1)
            ->create();
    }
}
