<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_event')->insert([
            [
                'id_event' => 1,
                'nama_event' => 'Indonesia International Motor Show (IIMS) 2024',
                'event_start_date' => '2024-04-05',
                'event_end_date' => '2024-04-14',
                'deskripsi' => 'Pameran otomotif terbesar di Indonesia yang menampilkan berbagai mobil dan motor terbaru, serta teknologi canggih di industri otomotif.',
                'alamat_event' => 'JIExpo Kemayoran, Jakarta',
                'image_cover' => 'https://example.com/iims2024.jpg',
                'lokasi' => 'JIExpo Kemayoran, Jakarta',
                'tipe_harga' => 'VIP',
                'harga' => 250000,
                'agenda_acara' => json_encode([
                    ['judul' => 'Pembukaan', 'waktu' => '10:00'],
                    ['judul' => 'Penampilan Mobil Konsep', 'waktu' => '12:00'],
                    ['judul' => 'Sesi 1: Mobil Listrik', 'waktu' => '14:00'],
                    ['judul' => 'Sesi 2: Teknologi Otomotif', 'waktu' => '16:00'],
                    ['judul' => 'Sesi 3: Test Drive Mobil Terbaru', 'waktu' => '09:00'],
                    ['judul' => 'Sesi 4: Workshop Modifikasi', 'waktu' => '11:00'],
                    ['judul' => 'Penutupan', 'waktu' => '17:00'],
                ]),
                'bintang_tamu' => json_encode(['CEO Perusahaan A', 'Racer B', 'Influencer Otomotif C']),
                'delete_event' => 'N',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id_event' => 2,
                'nama_event' => 'GIIAS (Gaikindo Indonesia International Auto Show) 2024',
                'event_start_date' => '2024-08-20',
                'event_end_date' => '2024-08-30',
                'deskripsi' => 'Pameran otomotif internasional yang menampilkan kendaraan terbaru dan teknologi inovatif dari berbagai produsen mobil global.',
                'alamat_event' => 'Indonesia Convention Exhibition (ICE), BSD City, Tangerang',
                'image_cover' => 'https://example.com/giias2024.jpg',
                'lokasi' => 'ICE BSD, Tangerang',
                'tipe_harga' => 'Reguler',
                'harga' => 150000,
                'agenda_acara' => json_encode([
                    ['judul' => 'Pembukaan', 'waktu' => '10:00'],
                    ['judul' => 'Sesi 1: Peluncuran Mobil Baru', 'waktu' => '12:00'],
                    ['judul' => 'Sesi 2: Kendaraan Ramah Lingkungan', 'waktu' => '14:00'],
                    ['judul' => 'Sesi 3: Teknologi Mobil Terkini', 'waktu' => '16:00'],
                    ['judul' => 'Sesi 4: Mobil Listrik', 'waktu' => '09:00'],
                    ['judul' => 'Sesi 5: Kompetisi Modifikasi Kendaraan', 'waktu' => '11:00'],
                    ['judul' => 'Penutupan', 'waktu' => '17:00'],
                ]),
                'bintang_tamu' => json_encode(['Pakar Otomotif A', 'Influencer Motor B', 'Pembalap C']),
                'delete_event' => 'N',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
