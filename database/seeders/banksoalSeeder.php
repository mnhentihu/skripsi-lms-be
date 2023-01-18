<?php

namespace Database\Seeders;

use App\Models\banksoal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class banksoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        banksoal::create([
            'subject' => 'Pengenalan Ilmu Kimia',
            'soal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur, velit sed molestie iaculis, augue tortor pretium tellus, in faucibus lectus lacus ut erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur, velit sed molestie iaculis, augue tortor pretium tellus, in faucibus lectus lacus ut erat.',
            'ansA' => 'Lorem',
            'ansB' => 'Ipsum',
            'ansC' => 'Dolor',
            'ansD' => 'Sit Amet',
            'corAns' => 'A',
            'level' => '1',
        ]);

        banksoal::create([
            'subject' => 'Pengenalan Ilmu Kimia',
            'soal' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur, velit sed molestie iaculis, augue tortor pretium tellus, in faucibus lectus lacus ut erat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur, velit sed molestie iaculis, augue tortor pretium tellus, in faucibus lectus lacus ut erat.',
            'ansA' => 'Lorem',
            'ansB' => 'Ipsum',
            'ansC' => 'Dolor',
            'ansD' => 'Sit Amet',
            'corAns' => 'A',
            'level' => '1',
        ]);
    }
}
