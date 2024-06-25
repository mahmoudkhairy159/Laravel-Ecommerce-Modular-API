<?php

namespace Modules\Item\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\App\Models\Admin;
use Modules\Brand\App\Models\Brand;
use Modules\Category\App\Models\Category;
use Modules\Item\App\Models\Item;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('ITEM-###'),
            'image' => $this->faker->imageUrl(640, 480, 'items', true),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'brand_id' => Brand::inRandomOrder()->value('id') ?? Brand::factory(),
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
            'rank' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement([Item::STATUS_ACTIVE, Item::STATUS_INACTIVE]),
            'created_by' => Admin::inRandomOrder()->value('id') ?? Admin::factory(),
            'updated_by' => Admin::inRandomOrder()->value('id') ?? Admin::factory(),
            'en' => [
                'name' => $this->faker->words(3, true),
                'short_description' => $this->faker->sentence,
                'description' => $this->faker->paragraph,

            ],
            'ar' => [
                'name' => $this->faker->words(3, true),
                'short_description' => $this->faker->sentence,
                'description' => $this->faker->paragraph,
            ],

        ];
    }
}
