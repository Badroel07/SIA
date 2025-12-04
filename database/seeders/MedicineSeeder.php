<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data obat dilengkapi dengan kolom detail sesuai migrasi

        $medicinesData = [
            [
                'name' => 'Paracetamol 500mg',
                'category' => 'Analgesik & Antipiretik',
                'description' => 'Obat penurun demam dan pereda nyeri ringan hingga sedang. Aman untuk anak dan dewasa.',
                'price' => 5000,
                'stock' => 150,
                'image' => 'medicines/paracetamol.jpg',
                'full_indication' => 'Digunakan untuk meredakan sakit kepala, sakit gigi, demam yang menyertai flu, nyeri otot dan sendi, serta nyeri ringan lainnya.',
                'usage_detail' => 'Dewasa: 1-2 tablet, 3-4 kali sehari. Anak (6-12 tahun): 1/2 - 1 tablet, 3-4 kali sehari. Diberikan sesudah makan. Maksimal 4 gram per hari.',
                'side_effects' => 'Reaksi hipersensitivitas, kerusakan hati (jika melebihi dosis), dan ruam kulit. Segera hentikan jika timbul gejala alergi.',
                'contraindications' => 'Tidak boleh diberikan pada pasien dengan gangguan fungsi hati yang berat atau alergi terhadap Paracetamol.',
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'category' => 'Antibiotik (Penisilin)',
                'description' => 'Obat antibiotik spektrum luas untuk mengobati infeksi bakteri yang sensitif terhadap Amoxicillin.',
                'price' => 15000,
                'stock' => 75,
                'image' => 'medicines/amoxicillin.jpg',
                'full_indication' => 'Mengobati infeksi saluran pernapasan atas dan bawah, infeksi telinga, hidung, tenggorokan, infeksi kulit dan jaringan lunak, serta infeksi saluran kemih.',
                'usage_detail' => 'Dosis dewasa: 250-500 mg setiap 8 jam atau 750 mg - 1 gram setiap 12 jam. Wajib dihabiskan sesuai resep dokter.',
                'side_effects' => 'Diare, mual, muntah, dan reaksi alergi (ruam). Jarang: kolitis pseudomembranosa.',
                'contraindications' => 'Hipersensitivitas terhadap penisilin, sefalosporin, atau antibiotik beta-laktam lainnya.',
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'category' => 'Anti-inflamasi Non-steroid (OAINS)',
                'description' => 'Peroral nyeri, demam, dan peradangan. Efektif untuk nyeri sendi, sakit kepala, dan nyeri haid.',
                'price' => 12500,
                'stock' => 120,
                'image' => 'medicines/ibuprofen.jpg',
                'full_indication' => 'Meredakan nyeri ringan hingga sedang (nyeri kepala, sakit gigi, nyeri otot), demam pada anak, dan dismenore (nyeri haid).',
                'usage_detail' => 'Dewasa: 200-400 mg setiap 4-6 jam jika diperlukan. Jangan melebihi 1200 mg per hari. Diminum sesudah makan untuk mengurangi iritasi lambung.',
                'side_effects' => 'Gangguan pencernaan (mual, muntah, dispepsia), pusing, dan retensi cairan.',
                'contraindications' => 'Ulkus peptikum aktif, riwayat asma yang dipicu OAINS, gangguan ginjal berat, dan trimester ketiga kehamilan.',
            ],
            [
                'name' => 'Cetirizine 10mg',
                'category' => 'Antihistamin',
                'description' => 'Obat antihistamin generasi kedua untuk meredakan gejala alergi tanpa efek kantuk berlebihan.',
                'price' => 8000,
                'stock' => 200,
                'image' => null,
                'full_indication' => 'Meredakan gejala yang berhubungan dengan rinitis alergi musiman dan perenial (bersin, hidung meler, mata gatal), serta urtikaria idiopatik kronis (biduran).',
                'usage_detail' => 'Dewasa dan anak > 12 tahun: 1 tablet 10 mg per hari. Anak 6-12 tahun: 5 mg dua kali sehari. Dapat diminum sebelum atau sesudah makan.',
                'side_effects' => 'Rasa kantuk (meskipun rendah), mulut kering, dan sakit kepala. Pada dosis tinggi dapat menyebabkan kelelahan.',
                'contraindications' => 'Pasien dengan hipersensitivitas terhadap cetirizine, hidroksizin, atau turunan piperazin lainnya.',
            ],
            [
                'name' => 'Salbutamol Inhaler',
                'category' => 'Bronkodilator',
                'description' => 'Obat hirup untuk mengatasi gejala asma dan PPOK dengan cepat.',
                'price' => 22000,
                'stock' => 50,
                'image' => null,
                'full_indication' => 'Meringankan bronkospasme pada semua jenis asma bronkial, bronkitis kronis, dan penyakit paru obstruktif kronis (PPOK). Juga digunakan sebagai pencegahan asma akibat olahraga.',
                'usage_detail' => 'Untuk asma akut: 1-2 hisapan (100-200 mcg) saat diperlukan. Dosis pencegahan sebelum olahraga: 2 hisapan 15 menit sebelumnya. Kocok sebelum digunakan.',
                'side_effects' => 'Gemetar halus (tremor), palpitasi (jantung berdebar), dan sakit kepala. Efek samping ini biasanya ringan dan sementara.',
                'contraindications' => 'Hipersensitivitas terhadap Salbutamol. Tidak direkomendasikan untuk penggunaan pada ancaman keguguran.',
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
