<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin([
            'name' => '管理者太郎',
            'email' => 'example100@gmail.com',
            'password' => bcrypt('password'),
            'profile' => '管理者です。'
        ]);
        $admin->save();
    }
}
