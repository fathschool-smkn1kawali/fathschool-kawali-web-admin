<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SyllabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Syllabus::factory(10)->create();
    }
}
