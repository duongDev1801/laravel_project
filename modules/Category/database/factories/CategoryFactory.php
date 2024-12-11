<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Category\src\Models\Category;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->randomElement([
            'Technology',
            'Books',
            'Clothing',
            'Food & Drink',
            'Sports',
            'Health',
            'Toys & Games',
            'Home & Garden',
            'Beauty & Personal Care',
            'Automotive',
            'Furniture',
            'Art & Crafts',
            'Music',
            'Games & Consoles',
            'Jewelry',
            'Grocery',
            'Pet Supplies',
            'Office Supplies',
            'Books & Stationery',
            'Baby Products'
        ]);

        $name = ucfirst($name);
        $parentId = $this->faker->randomElement(Category::pluck('id')->toArray()) ?: 0;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => $parentId,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {

    }
}
