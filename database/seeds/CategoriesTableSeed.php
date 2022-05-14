<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(['Javascipt', 'CSS', 'Codeigniter', 'Node js', 'React js', 'Vue js', 'Docker']);
        $categories->each(function($item) {
            App\Category::create([
                'category' => $item,
                'slug' => \Str::slug($item)
            ]);
        });
    }
}
