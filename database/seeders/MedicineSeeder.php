<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str; // Untuk membuat slug

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data obat dengan penyesuaian untuk kolom 'slug' dan 'stock'
        $medicinesData = [
            [
                'name' => 'Paracetamol',
                'category' => 'Analgesik & Antipiretik',
                'description' => 'Meredakan nyeri ringan hingga sedang dan menurunkan demam (500 mg).',
                'price' => 5000,
                'stock' => 150,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'category' => 'Antibiotik (Penisilin)',
                'description' => 'Mengobati infeksi bakteri, seperti infeksi saluran pernapasan, telinga, hidung, dan kulit.',
                'price' => 15000,
                'stock' => 75,
            ],
            [
                'name' => 'Ibuprofen',
                'category' => 'Anti-inflamasi Non-steroid (OAINS)',
                'description' => 'Meredakan nyeri, demam, dan peradangan, bekerja dengan menghambat produksi prostaglandin.',
                'price' => 12500,
                'stock' => 120,
            ],
            [
                'name' => 'Losartan',
                'category' => 'Antihipertensi (ARB)',
                'description' => 'Mengobati tekanan darah tinggi (hipertensi) dengan memblokir reseptor Angiotensin II.',
                'price' => 55000,
                'stock' => 45,
            ],
            [
                'name' => 'Metformin HCL',
                'category' => 'Antidiabetik Oral',
                'description' => 'Mengontrol kadar gula darah pada penderita Diabetes Melitus tipe 2 dengan meningkatkan sensitivitas insulin.',
                'price' => 10000,
                'stock' => 90,
            ],
            [
                'name' => 'Omeprazole',
                'category' => 'Penghambat Pompa Proton (PPI)',
                'description' => 'Mengobati penyakit refluks asam (GERD) dan sakit maag dengan mengurangi produksi asam lambung.',
                'price' => 30000,
                'stock' => 60,
            ],
            [
                'name' => 'Cetirizine',
                'category' => 'Antihistamin',
                'description' => 'Meredakan gejala alergi seperti bersin, hidung meler, dan gatal tanpa menyebabkan kantuk berlebihan.',
                'price' => 8000,
                'stock' => 200,
            ],
            [
                'name' => 'Simvastatin',
                'category' => 'Statin (Penurun Kolesterol)',
                'description' => 'Menurunkan kadar kolesterol LDL dan Trigliserida untuk pencegahan penyakit jantung.',
                'price' => 45000,
                'stock' => 30,
            ],
            [
                'name' => 'Salbutamol Inhaler',
                'category' => 'Bronkodilator',
                'description' => 'Meredakan gejala asma dan PPOK dengan melebarkan saluran pernapasan.',
                'price' => 22000,
                'stock' => 50,
            ],
            [
                'name' => 'Multivitamin Kompleks',
                'category' => 'Suplemen',
                'description' => 'Memenuhi kebutuhan vitamin dan mineral harian untuk menjaga daya tahan tubuh.',
                'price' => 35000,
                'stock' => 250,
            ],
        ];

        // 1. Kosongkan tabel medicines terlebih dahulu
        DB::table('medicines')->truncate();

        $processedMedicines = [];

        // 2. Tambahkan slug dan timestamps otomatis
        foreach ($medicinesData as $data) {
            $data['slug'] = Str::slug($data['name']);
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $processedMedicines[] = $data;
        }

        // 3. Masukkan data ke tabel 'medicines'
        DB::table('medicines')->insert($processedMedicines);
    }
}
