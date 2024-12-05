<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('tb_pelanggan')->insert([
            [
                'nama_pelanggan' => 'User',
                'telp_pelanggan' => '081234567890',
                'email_pelanggan' => 'user@gmail.com',
                'password_pelanggan' => Hash::make('password'),
                'password_reset_token' => null,
                'foto_pelanggan' => 'assets/images/components/avatar.png',
                'role_pelanggan' => 'pembeli',
                'status_pelanggan' => 'Aktif',
                'created_pelanggan' => Carbon::now(),
                'updated_pelanggan' => Carbon::now(),
                'delete_pelanggan' => 'N',
            ],
        ]);
        DB::table('tb_kategori_spare_part')->insert([
            'nama_kategori_spare_part' => 'Kaki-kaki',
        ]);
        DB::table('tb_bengkel')->insert([
            'id_bengkel' => 1,
            'id_pelanggan' => 1,
            'nama_bengkel' => 'Anak Curug',
            'tagline_bengkel' => 'Kendaraan rusak ke ancur aja',
            'foto_bengkel' => 'assets/images/components/ANCUR724.png',
            'foto_cover_bengkel' => 'assets/images/components/ANCUR724.png',
            'alamat_bengkel' => 'Komplek STPI, Jl. Raya STPI Pos 3 No.Blok H, RT.02/RW.02, Rancagong, Kec. Legok, Kabupaten Tangerang, Banten 15820',
            'provinsi' => '36',
            'kota' => '36.03',
            'kecamatan' => '36.03.20',
            'whatsapp' => '6281234567890',
            'tiktok' => null,
            'instagram' => 'ancur.id',
            'open_day' => 'Monday',
            'close_day' => 'Saturday',
            'open_time' => '08:00:00',
            'close_time' => '17:00:00',
            'service_available' => null,
            'payment' => null,
            'rekening_bank' => null,
            'qris_qrcode' => null,
            'kodepos_bengkel' => '12345',
            'gmaps' => 'https://maps.app.goo.gl/sFvLT8PosRzbmuE8A',
            'lokasi_bengkel' => null,
            'lat_bengkel' => null,
            'long_bengkel' => null,
            'status_bengkel' => 'Active',
            'POS' => 'N',
            'create_bengkel' => Carbon::now(),
            'delete_bengkel' => 'N',
        ]);
        DB::table('tb_produk')->insert([
            [
                'id_produk' => 1,
                'id_bengkel' => 1,
                'id_kategori_spare_part' => 1,
                'kualitas_produk' => 'Original',
                'merk_produk' => 'Motul',
                'nama_produk' => 'Oli 15W-40',
                'harga_produk' => 150000,
                'keterangan_produk' => 'Kualitas original dan bagus',
                'foto_produk' => 'https://media.istockphoto.com/id/1046550104/id/foto/tabung-oli-motor-plastik-dengan-berbagai-jenis-oli-motor-pada-latar-belakang-terisolasi-putih.jpg?s=612x612&w=0&k=20&c=cfVhAi13q8COlpX0VikWSxqGZ-6Wf0lbSk5HFPgjWPI=',
                'stok_produk' => 100,
                'create_produk' => Carbon::now(),
                'delete_produk' => 'N',
            ],
            [
                'id_produk' => 2,
                'id_bengkel' => 1,
                'id_kategori_spare_part' => 1,
                'kualitas_produk' => 'Original',
                'merk_produk' => 'Motul',
                'nama_produk' => 'Oli 20W-50',
                'harga_produk' => 170000,
                'keterangan_produk' => 'Oli dengan performa tinggi untuk mesin motor',
                'foto_produk' => 'https://cdn2.louis.de/dynamic/articles/o_resize,w_1800,h_1800,m_limit,c_fff/ec.b3.fe.H1Motul71004T20W5010037630.JPG',
                'stok_produk' => 80,
                'create_produk' => Carbon::now(),
                'delete_produk' => 'N',
            ],
        ]);
        DB::table('tb_spare_part')->insert([
            [
                'id_spare_part' => 1,
                'id_bengkel' => 1,
                'id_jenis_spare_part' => null,
                'id_kategori_spare_part' => 1,
                'kualitas_spare_part' => 'Original',
                'merk_spare_part' => 'Bosch',
                'nama_spare_part' => 'Air Filter',
                'harga_spare_part' => 75000,
                'keterangan_spare_part' => 'Kualitas original dan bagus',
                'foto_spare_part' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS3AFyyrkXYAFKackbG85WAqAQt94dUeHQnyA&s',
                'stok_spare_part' => 150,
                'create_spare_part' => Carbon::now(),
                'delete_spare_part' => 'N',
            ],
            [
                'id_spare_part' => 2,
                'id_bengkel' => 1,
                'id_jenis_spare_part' => null,
                'id_kategori_spare_part' => 1,
                'kualitas_spare_part' => 'Original',
                'merk_spare_part' => 'Denso',
                'nama_spare_part' => 'Spark Plug',
                'harga_spare_part' => 50000,
                'keterangan_spare_part' => 'Spark plug kualitas tinggi untuk performa mesin optimal',
                'foto_spare_part' => 'https://cdn2.louis.de/dynamic/articles/o_resize,w_1800,h_1800,m_limit,c_fff/ec.b3.fe.H1Motul71004T20W5010037630.JPG',
                'stok_spare_part' => 120,
                'create_spare_part' => Carbon::now(),
                'delete_spare_part' => 'N',
            ],
        ]);
        DB::table('tb_services')->insert([
            [
                'id_services' => 1,
                'id_bengkel' => 1,
                'nama_services' => 'Ganti Oli',
                'harga_services' => 150000,
                'keterangan_services' => 'Ganti oli untuk motor Anda',
                'foto_services' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTv6baegFXwwN8pt3gtxmFt6aXu139kb8xrqg&s',
                'create_services' => Carbon::now(),
                'delete_services' => 'N',
            ],
            [
                'id_services' => 2,
                'id_bengkel' => 1,
                'nama_services' => 'Tune Up',
                'harga_services' => 200000,
                'keterangan_services' => 'Servis untuk performa mesin yang lebih baik',
                'foto_services' => 'https://c1.staticflickr.com/7/6184/6053500178_eca1f4ec8d_b.jpg',
                'create_services' => Carbon::now(),
                'delete_services' => 'N',
            ],
        ]);

    }
}
