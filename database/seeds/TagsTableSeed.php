<?php

use Illuminate\Database\Seeder;

class TagsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['Design', 'Figma', 'Visual Code', 'Sublime', 'CI/CD']);
        $tags->each(function($item) {
            App\Tag::create([
                'name' => $item,
                'slug' => \Str::slug($item)
            ]);
        });
    }
}
