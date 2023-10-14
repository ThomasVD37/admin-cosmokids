<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Lesson;
use App\Models\Type;
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
        $michel = User::factory()->create([
            'email' => "michel@wanadoo.fr",
            'password' => '$2y$10$2koyw2rE6r1pHc4v2du9JurFTKffs68pAikFpl.o1HJb8Rl6wx1Si', // Michel$34
            'pseudo' => "Michel",
        ]);

        $josiane = User::factory()->create([
            'email' => "josiane@sfr.fr",
            'password' => '$2y$10$sx/XwV./NEFKWz.1LjzdNeSZ2.ISB5OV4UI.FlWpKEi/Xea9FIF1e', // 123456*Azerty
            'pseudo' => "Josiane",
        ]);

        User::factory()->create([
            'email' => "therese@exemple.com",
            'password' => '$2y$10$8WYUR1.EkqydK5nmv7dbM.0lbItYlZ9tir4/qZl.sANutINaFIu56', // oClock!7000
            'pseudo' => "Therese roxor du 22",
        ]);

        //$user =  User::factory(10)->create();

        // Type::factory()->create([
        //     "name" => "Puzzle"
        // ]);

        Type::factory()->create([
            "name" => "Quizz"
        ]);
        Type::factory()->create([
            "name" => "Frise interactive"
        ]);
        Type::factory()->create([
            "name" => "Association"
        ]);

        Activity::factory(3)->has(User::factory()->count(rand(0,5)))->create([
            "type_id" => rand(1,3),
        ]);

        Activity::factory(3)->hasAttached($michel)->create([
            "type_id" => rand(1,3),
        ]);

        Activity::factory(1)->hasAttached($josiane)->create([
            "type_id" => rand(1,3),
        ]);

        // $activity = Activity::factory(4)->create([
        //     "type_id" => rand(1,4),
        // ]);

        // Lesson::factory(3)->has(User::factory()->count(rand(0,5)))->create();

        // Lesson::factory(3)->hasAttached($michel)->hasAttached($activity->random())->create();

        // Lesson::factory(1)->hasAttached($josiane)->create();

        // for ($i=0; $i < 6; $i++) {
        //     Lesson::factory(1)->hasAttached($activity->random())->create();
        // }

    }
}
