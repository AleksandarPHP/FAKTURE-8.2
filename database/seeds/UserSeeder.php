<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array('id' => '1','first_name' => 'admin','last_name' => '2','username' => 'aco@soft4tech.com','password' => '$2y$10$GwESjirh5rldowHDZmldeuTAVpbkLM6w.Mk.cKq2X.C3iFqQp7na.','remember_token' => NULL,'is_active' => '1','is_admin' => '1','image' => '1725123589_aleksandar-jovanovic.jpg','created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:26'),
            array('id' => '2','first_name' => 'admin','last_name' => '1','username' => 'info@soft4tech.com','password' => '$2y$10$amh6iOaLye2uf9Lekn2RSOcfEMN2XKzEecB8CMFjjgAofLDOw7Dfq','remember_token' => 'j2vJaNnt4oSXiIbmhSrFVT1sJby5FWZgpLmIg8p7zvAEVXcwRs2G3pxbKOYs','is_active' => '1','is_admin' => '1','image' => NULL,'created_at' => '2020-05-05 17:25:23','updated_at' => '2020-05-06 16:53:55'),
        ));
    }
}
