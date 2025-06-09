<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $faker = Faker::create('vi_VN');

            $userId = DB::table('users')->insertGetId([
                'name' => "Kiểm Duyệt Viên",
                'email' => 'kiemduyetvien@tlu.edu.vn',
                'phone' => '024' . $faker->numerify('#######'),
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $admin = DB::table('users')->insertGetId([
                'name' => "Quản trị viên",
                'email' => 'admin@tlu.edu.vn',
                'phone' => '024' . $faker->numerify('#######'),
                'password' => Hash::make('password123'),
                'is_active' => true,
                'email_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            DB::table('user_has_roles')->insert([
                'user_id' => $userId,
                'role_id' => 4,
            ]);

            DB::table('user_has_roles')->insert([
                'user_id' => $admin,
                'role_id' => 999,
            ]);
    }
}
