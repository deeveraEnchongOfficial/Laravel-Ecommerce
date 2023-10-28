<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'first_name'=>'Admin',
                'last_name'=>'Admin',
                'email'=>'admin@gmail.com',
                'phone_number' => '',
                'address' => '',
                'password'=>Hash::make('1111'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'User',
                'first_name'=>'User',
                'last_name'=>'User',
                'email'=>'user@gmail.com',
                'phone_number' => '',
                'address' => '',
                'password'=>Hash::make('1111'),
                'role'=>'user',
                'status'=>'active'
            ),
            array(
                'name'=>'DeliveryUser',
                'first_name'=>'DeliveryUser',
                'last_name'=>'DeliveryUser',
                'email'=>'delivery_user@gmail.com',
                'phone_number' => '',
                'address' => '',
                'password'=>Hash::make('1111'),
                'role'=>'delivery_user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);

    }
}
