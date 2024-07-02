<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kitap>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = DB::table('users')->inRandomOrder()->first();
        $brand = DB::table('brands')->inRandomOrder()->first();
        $year = DB::table('years')->inRandomOrder()->first();
        $booklang = DB::table('booklangs')->inRandomOrder()->first();
        $writertwo = $this->faker->cityPrefix();
        $name = $brand->name . ' ' . $writertwo;
        $createdAt = fake()->dateTimeBetween('-1 year', '-1 week');
        return [
            'user_id' => $user->id,
            'brand_id' => $brand->id,
            'booklang_id' => $booklang->id,
            'name' => $name,
            'writertwo' => $writertwo,
            'year_id' => $year->id,
            'description' => fake()->paragraph(),
            'price' => rand(50, 500),
            'bookspage' => rand(30, 400),
            'bar_code' => $this->faker->unique()->isbn13(),
            'viewed' => rand(0, 300),
            'favorited' => rand(0, 60),
            'created_at' => $createdAt,
            'updated_at' => Carbon::parse($createdAt)->addDays(rand(0, 6))->addHours(rand(0, 23)),
        ];
    }
}
