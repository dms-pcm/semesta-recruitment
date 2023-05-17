<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Syarat;

class SyaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'syarat' => 'Surat Lamaran',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'CV',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Pas Foto',
                'type' => 'file',
                'format' => 'png,jpeg,jpg'
            ],
            [
                'syarat' => 'Foto Full Body',
                'type' => 'file',
                'format' => 'png,jpeg,jpg'
            ],
            [
                'syarat' => 'Ijazah',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'SKHUN',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Nilai Raport',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Surat Keterangan Sehat',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Tidak Buta Warna',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Tinggi Badan',
                'type' => 'text',
                'format' => null
            ],
            [
                'syarat' => 'Berat Badan',
                'type' => 'text',
                'format' => null
            ],
            [
                'syarat' => 'Essay Tentang Pengalaman Hidup',
                'type' => 'file',
                'format' => 'pdf'
            ],
            [
                'syarat' => 'Essay Tentang Target Masa Depan',
                'type' => 'file',
                'format' => 'pdf'
             ]
        ];

        foreach($data as $d){
            Syarat::create([
                'syarat' => $d['syarat'],
                'type' => $d['type'],
                'format' => $d['format'],
            ]);
        }
    }
}
