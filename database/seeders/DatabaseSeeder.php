<?php

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Article\Categorie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        Categorie::factory(10)->create();
        Article::factory(200)->create();

        $categories = Categorie::all();

        Article::all()->each(function ($article) use ($categories) {
            $article->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
