<?php

namespace Database\Seeders;

use App\Models\Article\Article;
use App\Models\Categorie\Categorie;
use App\Models\Fournisseur\Fournisseur;
use App\Models\User;
use App\Models\Role\Role;
use Illuminate\Database\Seeder;
use App\Models\Personnel\Fonction;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        $users = User::all();

        foreach (config('constants.categories.articles') as $categorie) {
            Categorie::create($categorie);
        }

        foreach (config('constants.articles') as $article) {
            $article = Article::create($article);
            $article->categories()->attach(1);
        }

        foreach (config('constants.fournisseurs') as $fournisseur) {
            Fournisseur::create($fournisseur);
        }

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
    }
}
