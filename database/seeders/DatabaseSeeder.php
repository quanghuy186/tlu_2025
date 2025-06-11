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
            PermissionSeeder::class,
            RoleHasPermissionSeeder::class,
            DepartmentUsersSeeder::class,
            DepartmentSeeder::class,
            TeacherSeeder::class,
            ClassSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
            ForumCategoriesSeeder::class,
            NotificationCategoriesSeeder::class,
        ]);
    }
}
