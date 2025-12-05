<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan Faker bahasa Indonesia

        // 1. Kosongkan tabel medicines terlebih dahulu
        DB::table('medicines')->truncate();

        // Daftar Kategori yang akan diacak
        $categories = [
            'Analgesik & Antipiretik',
            'Antibiotik (Penisilin)',
            'Anti-inflamasi Non-steroid (OAINS)',
            'Antihistamin',
            'Bronkodilator',
            'Suplemen Vitamin',
            'Antasida',
            'Obat Batuk & Flu'
        ];

        $medicines = [];
        $totalInitialStock = 0;

        for ($i = 1; $i <= 100; $i++) {
            $name = $faker->words(rand(1, 3), true) . ($i < 10 ? ' Forte' : ' ' . rand(100, 500) . 'mg');
            $category = $faker->randomElement($categories);
            $stock = rand(0, 50);
            $price = rand(5, 150) * 1000;

            // Simulasikan total stok untuk perhitungan Dashboard
            $totalInitialStock += 150; // Asumsi stok awal per item max 150

            // Simulasikan beberapa obat sudah terjual
            $totalSold = rand(0, 100);

            $medicines[] = [
                'name' => $name,
                'slug' => Str::slug($name . '-' . $i),
                'category' => $category,
                'price' => $price,
                'stock' => $stock,
                'total_sold' => $totalSold,
                'image' => $faker->boolean(20) ? 'medicines/placeholder-' . $faker->numberBetween(1, 5) . '.jpg' : null,

                // Detail Informasi (Diambil dari Faker)
                'description' => $faker->sentence(10),
                'full_indication' => $faker->paragraph(2),
                'usage_detail' => $faker->sentence(5) . " Dosis: " . rand(1, 3) . " kali sehari.",
                'side_effects' => $faker->boolean(60) ? $faker->sentence(6) : 'Tidak ada efek samping signifikan.',
                'contraindications' => $faker->boolean(40) ? $faker->sentence(4) : 'Hipersensitivitas terhadap kandungan obat.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // 2. Masukkan 100 data ke tabel 'medicines'
        DB::table('medicines')->insert($medicines);

        // Optional: Update total Initial Stock di DashboardController jika perlu
    }
}
