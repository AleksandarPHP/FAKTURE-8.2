<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Detail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('details')->insert(array(
            array('id' => '1','bank_name' => 'bank name','bank_account' => 'bank acc','SWIFT' => 'swift', 'bank_acc' => 'acc','alternative_payment' => 'alternative_payment','alternative_payment_acc' => 'alternative_payment_acc','alternative_payment2' => 'alternative_payment2 ','alternative_payment_acc2' => 'alternative_payment_acc2','PDV'=>'PDV','include_pdv'=>'include_pdv','created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:26'),
        ));
    }
}
