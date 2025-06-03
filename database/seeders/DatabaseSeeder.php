<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ForumCategoriesSeeder::class,
            NotificationCategoriesSeeder::class,
            DepartmentUsersSeeder::class,
            DepartmentSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class
        ]);
    }
}
