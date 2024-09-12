<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MailSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mail_settings')->insert(array(
            array('id' => '1','text' => 'any text','signature_in_email' => 'email ','invoice_tracking' => 'tracking', 'created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:26'),
        ));
    }
}
