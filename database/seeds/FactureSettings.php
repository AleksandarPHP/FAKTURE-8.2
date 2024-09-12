<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactureSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('facture_settings')->insert(array(
            array('id' => '1','limit_facture' => '12','fee' => '12 ','repet_facture' => '12', 'next_repet_facture' => '1212', 'created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:26'),
        ));
    }
}
