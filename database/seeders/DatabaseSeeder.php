<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\src\Models\User;
use Modules\Category\src\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();

        Category::factory(5)->create();

        // Tạo danh mục con
        Category::factory(15)->create();
    }
}
