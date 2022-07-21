<?php

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Article\Categorie;
use App\Models\Personnel\Fonction;
use App\Models\Role\Role;
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
        /*Categorie::factory(10)->create();
        Article::factory(200)->create();
        Role::factory(20)->create();

        $categories = Categorie::all(); */

        $users = User::all();

        foreach (config('constants.fonctions') as $name => $description) {
            $fonction = Fonction::create([
                'nom_fonction' => $name,
                'description_fonction' => $description,
            ]);
        }

        $fonctions = Fonction::all();

        foreach (config('constants.roles') as $name => $description) {
            $role = Role::create([
                'nom_role' => $name,
                'description' => $description,
            ]);

            foreach ($fonctions as $fonction) {
                $fonction->permissions()->attach($role->id);
            }

            foreach ($users as $user) {
                $user->roles()->attach($role->id);
            }
        }

        foreach ($users as $user) {
            $user->fonctions()->attach(rand(1, 3));
        }

        /*User::all()->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1, 3))->pluck('id')->toArray()
            );
        });*/

        /*Article::all()->each(function ($article) use ($categories) {
            $article->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });*/
    }
}
