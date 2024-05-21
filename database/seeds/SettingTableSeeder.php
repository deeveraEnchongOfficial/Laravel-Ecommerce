<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Padilla Gowns and Barongs Rent offers a curated selection of elegant gowns and timeless barongs for rent, ensuring you shine on any occasion.",
            'short_des'=>"Padilla Gowns and Barongs Rent offers a curated selection of elegant gowns and timeless barongs for rent, ensuring you shine on any occasion.",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"72 Padilla St, Padilla Gomez, San Carlos City, Pangasinan",
            'email'=>"Doc.AllenVillavadePadilla@gmail.com",
            'phone'=>"+060 (800) 801-582",
        );
        DB::table('settings')->insert($data);
    }
}
