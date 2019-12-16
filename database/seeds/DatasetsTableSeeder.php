<?php

use App\Models\Dataset;
use Illuminate\Database\Seeder;

class DatasetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Dataset::where('nis', '11112222')->first() === null) {
            $dataset                = new Dataset();
            $dataset->nis           = "11112222";
            $dataset->fullname      = "Monkey Luffy";
            $dataset->parent_name   = "Monkey Dragon";
            $dataset->birthdate     = "1996-02-12";
            $dataset->birthplace    = "Alabasta";
            $dataset->entrydate     = 2011;
            $dataset->outdate       = 2014;
            $dataset->status        = '0';
            $dataset->save();
        }
    }
}
