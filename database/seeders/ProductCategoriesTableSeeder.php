<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('product_categories')->truncate();

        $categoriesData = collect([
            [
                'name' => 'Clothes',
                'slug' => Str::slug('Clothes'),
            ],
            [
                'name' => 'Shoes',
                'slug' => Str::slug('Shoes'),
            ],
            [
                'name' => 'Home & Appliances',
                'slug' => Str::slug('Home & Appliances'),
            ],
        ]);

        $categoriesData->each(function ($categoryData) {
            ProductCategory::updateOrCreate($categoryData);
        });
    }
}
