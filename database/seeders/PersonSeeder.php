<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person = new Person();
        $person->id = "1";
        $person->first_name = "Arief";
        $person->last_name = "Hermawan";
        $person->save();

        $person = new Person();
        $person->id = "2";
        $person->first_name = "Hilmi";
        $person->last_name = "Muharrom";
        $person->save();

        $person = new Person();
        $person->id = "3";
        $person->first_name_upper = "Arief";
        $person->last_name = "Hermawan";
        $person->save();

        $person = new Person();
        $person->id = "4";
        $person->first_name_upper = "Hilmi";
        $person->last_name = "Muharrom";
        $person->save();

        $person = new Person();
        $person->id = "5";
        $person->first_name_upper = "Arief";
        $person->last_name_upper = "Hermawan";
        $person->save();

        $person = new Person();
        $person->id = "6";
        $person->first_name_upper = "Hilmi";
        $person->last_name_upper = "Muharrom";
        $person->save();
    }
}
