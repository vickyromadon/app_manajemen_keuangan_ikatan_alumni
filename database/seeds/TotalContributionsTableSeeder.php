<?php

use App\Models\TotalContribution;
use Illuminate\Database\Seeder;

class TotalContributionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (TotalContribution::where('id', 1)->first() === null) {
            $totalContribution          = new TotalContribution();
            $totalContribution->dana    = 0;
            $totalContribution->save();
        }
    }
}
