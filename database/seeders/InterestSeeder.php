<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interest;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array("Reading", "Video Games", "Sports", "Travelling");
        foreach ($array as $key => $value) {

        	$interest = new Interest;
            $interest->name = $value;
            $interest->save();

        }
        
    }
}
