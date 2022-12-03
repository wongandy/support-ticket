<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = ['label 1', 'label 2', 'label 3'];

        foreach ($labels as $label) {
            Label::create([
                'name' => $label,
                'slug' => $label,
            ]);
        }
    }
}
