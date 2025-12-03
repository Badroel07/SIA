<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        // Data obat sekarang dilengkapi dengan nama file gambar
        // Pastikan kamu nanti menyimpan file gambar asli dengan nama yang sama 
        // di folder: storage/app/public/medicines/

        $medicinesData = [
            [
                'name' => 'Paracetamol',
                'category' => 'Analgesik & Antipiretik',
                'description' => 'Meredakan nyeri ringan hingga sedang dan menurunkan demam (500 mg).',
                'price' => 5000,
                'stock' => 150,
                'image' => 'medicines/paracetamol.jpg',
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'category' => 'Antibiotik (Penisilin)',
                'description' => 'Mengobati infeksi bakteri, seperti infeksi saluran pernapasan, telinga, hidung, dan kulit.',
                'price' => 15000,
                'stock' => 75,
                'image' => 'medicines/amoxicillin.jpg',
            ],
            [
                'name' => 'Ibuprofen',
                'category' => 'Anti-inflamasi Non-steroid (OAINS)',
                'description' => 'Meredakan nyeri, demam, dan peradangan.',
                'price' => 12500,
                'stock' => 120,
                'image' => 'medicines/ibuprofen.jpg',
            ],
            [
                'name' => 'Losartan',
                'category' => 'Antihipertensi (ARB)',
                'description' => 'Mengobati tekanan darah tinggi (hipertensi).',
                'price' => 55000,
                'stock' => 45,
                'image' => 'medicines/losartan.jpg',
            ],
            [
                'name' => 'Metformin HCL',
                'category' => 'Antidiabetik Oral',
                'description' => 'Mengontrol kadar gula darah pada penderita Diabetes.',
                'price' => 10000,
                'stock' => 90,
                'image' => 'medicines/metformin.jpg',
            ],
            [
                'name' => 'Omeprazole',
                'category' => 'Penghambat Pompa Proton (PPI)',
                'description' => 'Mengobati penyakit refluks asam (GERD).',
                'price' => 30000,
                'stock' => 60,
                'image' => null, // Key image HARUS ADA, walaupun nilainya null
            ],
            [
                'name' => 'Cetirizine',
                'category' => 'Antihistamin',
                'description' => 'Meredakan gejala alergi seperti bersin, hidung meler, dan gatal tanpa menyebabkan kantuk berlebihan.',
                'price' => 8000,
                'stock' => 200,
                'image' => null,
            ],
            [
                'name' => 'Simvastatin',
                'category' => 'Statin (Penurun Kolesterol)',
                'description' => 'Menurunkan kadar kolesterol LDL dan Trigliserida untuk pencegahan penyakit jantung.',
                'price' => 45000,
                'stock' => 30,
                'image' => null,
            ],
            [
                'name' => 'Salbutamol Inhaler',
                'category' => 'Bronkodilator',
                'description' => 'Meredakan gejala asma dan PPOK dengan melebarkan saluran pernapasan.',
                'price' => 22000,
                'stock' => 50,
                'image' => null,
            ],
            [
                'name' => 'Multivitamin Kompleks',
                'category' => 'Suplemen',
                'description' => 'Memenuhi kebutuhan vitamin dan mineral harian untuk menjaga daya tahan tubuh.',
                'price' => 35000,
                'stock' => 250,
                'image' => null,
            ],
        ];

        DB::table('medicines')->truncate();

        $processedMedicines = [];

        foreach ($medicinesData as $data) {
            $data['slug'] = Str::slug($data['name']);
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $processedMedicines[] = $data;
        }

        DB::table('medicines')->insert($processedMedicines);
    }
}
