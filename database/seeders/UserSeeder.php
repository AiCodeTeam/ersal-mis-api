<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $datas = [
             ['name' => 'Hedayat','email'=>'nikzad.hedayatullah@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'Mansour','email'=>'mansour@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'wayel','email'=>'wayel@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'naweed','email'=>'naweed@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'mohsin','email'=>'mohsin@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'zakir','email'=>'zakir@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'Ahmad','email'=>'ahmad@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'mahmood','email'=>'mahmood@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'ali','email'=>'ali@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'hassan','email'=>'hasan@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'wali','email'=>'wali@gmail.com','password'=>Hash::make('12345678')],
             ['name' => 'admin','email'=>'admin.user@gmail.com','password'=>Hash::make('admin@user')]
            ];
     
            foreach($datas as $key => $value){
                User::create($value);
            }
         }
    }
}
