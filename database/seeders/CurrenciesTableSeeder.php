<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('currencies')->truncate();

        $currenciesData = collect([
            [
                'name' => 'Malaysian Ringgit',
                'slug' => Str::slug('Malaysian Ringgit'),
                'code' => 'MYR',
                'symbol' => 'RM',
            ],
            [
                'name' => 'US Dollar',
                'slug' => Str::slug('US Dollar'),
                'code' => 'USD',
                'symbol' => '$',
            ],
            [
                'name' => 'Singapore Dollar',
                'slug' => Str::slug('Singapore Dollar'),
                'code' => 'SGD',
                'symbol' => '$',
            ]
        ]);

        $currenciesData->each(function ($currencyData) {
            $toCheck = [
                'name' => $currencyData['name'],
                'slug' => $currencyData['slug'],
            ];

            $toUpdate = [
                'code' => $currencyData['code'],
                'symbol' => $currencyData['symbol'],
            ];

            Currency::updateOrCreate($toCheck, $toUpdate);
        });
    }
}
