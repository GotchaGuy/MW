<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['title' => 'Education']);
        Category::create(['title' => 'Poverty']);
        Category::create(['title' => 'Health']);
    }
}
