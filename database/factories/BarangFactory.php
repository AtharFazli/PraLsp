<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Barang::class;
    public function definition(): array
    {
        return [
            'nama_barang' => $this->faker->word,
            'harga_barang' => $this->faker->randomFloat(2, 100, 1000),
            'gambar_barang' => 'gambar/' . $this->faker->image('public/gambar', 400, 300, null, false),
        ];
    }
}
