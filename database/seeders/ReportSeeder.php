<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->insert([
            'name' => 'Invoice - All Tasks by Project and Status',
        ]);

        DB::table('reports')->insert([
            'name' => 'Report - All Tasks by Project',
        ]);
    }
}
