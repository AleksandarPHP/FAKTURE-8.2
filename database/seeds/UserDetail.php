<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDetail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_details')->insert(array(
            array('id' => '1','company_name' => 'Company','telefon' => 'telefon','city' => 'city', 'postal_code' => 'code','adresa' => 'address','JIB' => 'jib','PDV_ID' => '1123123','image' => '1725123589_aleksandar-jovanovic.jpg','created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:26'),
        ));
    }
}
