<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            // Antihipertensi - ACE Inhibitor
            [
                'code' => 'OBT-001',
                'name' => 'Captopril',
                'generic_name' => 'Captopril',
                'dosage_form' => 'Tablet',
                'strength' => '25mg',
                'category' => 'ACE Inhibitor',
                'description' => 'Obat antihipertensi golongan ACE inhibitor untuk menurunkan tekanan darah tinggi.',
                'side_effects' => 'Batuk kering, pusing, sakit kepala, kelelahan',
                'contraindications' => 'Kehamilan, riwayat angioedema',
                'instructions' => 'Diminum 1 jam sebelum makan',
            ],
            [
                'code' => 'OBT-002',
                'name' => 'Lisinopril',
                'generic_name' => 'Lisinopril',
                'dosage_form' => 'Tablet',
                'strength' => '10mg',
                'category' => 'ACE Inhibitor',
                'description' => 'ACE inhibitor untuk pengobatan hipertensi dan gagal jantung.',
                'side_effects' => 'Batuk kering, pusing, hipotensi',
                'contraindications' => 'Kehamilan, angioedema',
                'instructions' => 'Dapat diminum dengan atau tanpa makanan',
            ],
            // Calcium Channel Blocker
            [
                'code' => 'OBT-003',
                'name' => 'Amlodipine',
                'generic_name' => 'Amlodipine Besylate',
                'dosage_form' => 'Tablet',
                'strength' => '5mg',
                'category' => 'Calcium Channel Blocker',
                'description' => 'Calcium channel blocker untuk hipertensi dan angina.',
                'side_effects' => 'Edema perifer, pusing, flushing, sakit kepala',
                'contraindications' => 'Syok kardiogenik, stenosis aorta berat',
                'instructions' => 'Diminum sekali sehari pada waktu yang sama',
            ],
            [
                'code' => 'OBT-004',
                'name' => 'Nifedipine',
                'generic_name' => 'Nifedipine',
                'dosage_form' => 'Tablet',
                'strength' => '10mg',
                'category' => 'Calcium Channel Blocker',
                'description' => 'CCB untuk hipertensi dan angina pektoris.',
                'side_effects' => 'Sakit kepala, flushing, edema, konstipasi',
                'contraindications' => 'Syok kardiogenik',
                'instructions' => 'Jangan mengunyah atau menghancurkan tablet',
            ],
            // Beta Blocker
            [
                'code' => 'OBT-005',
                'name' => 'Bisoprolol',
                'generic_name' => 'Bisoprolol Fumarate',
                'dosage_form' => 'Tablet',
                'strength' => '5mg',
                'category' => 'Beta Blocker',
                'description' => 'Beta blocker selektif untuk hipertensi dan gagal jantung.',
                'side_effects' => 'Bradikardia, kelelahan, pusing, tangan/kaki dingin',
                'contraindications' => 'Bradikardia berat, AV block, asma berat',
                'instructions' => 'Diminum pagi hari dengan atau tanpa makanan',
            ],
            [
                'code' => 'OBT-006',
                'name' => 'Propranolol',
                'generic_name' => 'Propranolol HCl',
                'dosage_form' => 'Tablet',
                'strength' => '40mg',
                'category' => 'Beta Blocker',
                'description' => 'Beta blocker non-selektif untuk hipertensi dan aritmia.',
                'side_effects' => 'Bradikardia, bronkospasme, kelelahan',
                'contraindications' => 'Asma, bradikardia, syok kardiogenik',
                'instructions' => 'Diminum sebelum makan',
            ],
            // Diuretik
            [
                'code' => 'OBT-007',
                'name' => 'Hydrochlorothiazide',
                'generic_name' => 'Hydrochlorothiazide',
                'dosage_form' => 'Tablet',
                'strength' => '25mg',
                'category' => 'Diuretik',
                'description' => 'Diuretik thiazide untuk hipertensi dan edema.',
                'side_effects' => 'Hipokalemia, peningkatan asam urat, hiperglikemia',
                'contraindications' => 'Anuria, hipersensitivitas sulfonamid',
                'instructions' => 'Diminum pagi hari untuk menghindari nokturia',
            ],
            [
                'code' => 'OBT-008',
                'name' => 'Furosemide',
                'generic_name' => 'Furosemide',
                'dosage_form' => 'Tablet',
                'strength' => '40mg',
                'category' => 'Diuretik',
                'description' => 'Diuretik loop untuk edema dan hipertensi.',
                'side_effects' => 'Hipokalemia, dehidrasi, hipotensi',
                'contraindications' => 'Anuria, hipovolemia berat',
                'instructions' => 'Diminum pagi hari dengan makanan',
            ],
            // Antihipertensi Lainnya
            [
                'code' => 'OBT-009',
                'name' => 'Valsartan',
                'generic_name' => 'Valsartan',
                'dosage_form' => 'Tablet',
                'strength' => '80mg',
                'category' => 'Antihipertensi',
                'description' => 'ARB (Angiotensin Receptor Blocker) untuk hipertensi.',
                'side_effects' => 'Pusing, hiperkalemia, gangguan ginjal',
                'contraindications' => 'Kehamilan, gangguan hati berat',
                'instructions' => 'Dapat diminum dengan atau tanpa makanan',
            ],
            [
                'code' => 'OBT-010',
                'name' => 'Candesartan',
                'generic_name' => 'Candesartan Cilexetil',
                'dosage_form' => 'Tablet',
                'strength' => '8mg',
                'category' => 'Antihipertensi',
                'description' => 'ARB untuk hipertensi dan gagal jantung.',
                'side_effects' => 'Pusing, sakit kepala, infeksi saluran napas',
                'contraindications' => 'Kehamilan, gangguan hati berat',
                'instructions' => 'Diminum sekali sehari pada waktu yang sama',
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
