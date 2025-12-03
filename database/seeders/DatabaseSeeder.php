<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan pemanggilan DrugSeeder di sini.
        $this->call([
            MedicineSeeder::class, // Panggil seeder obat kita
            // Jika ada seeder lain, tambahkan di bawah
        ]);
    }
}
