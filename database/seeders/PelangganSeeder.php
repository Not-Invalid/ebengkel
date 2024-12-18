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
            [
                'nama_pelanggan' => 'Miska',
                'telp_pelanggan' => '081234567890',
                'email_pelanggan' => 'user@test.com',
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
        DB::table('tb_alamat_pengiriman')->insert([
            [
                'id_alamat_pengiriman' => 1,
                'id_pelanggan' => 2,
                'nama_penerima' => 'Miska',
                'telp_penerima' => '08123456780',
                'lokasi_alamat_pengiriman' => 'Merdeka Square, Jalan Lapangan Monas, Gambir, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10110',
                'provinsi_id' => 17,
                'kota_id' => 48,
                'kecamatan_id' => 684,
                'kodepos_alamat_pengiriman' => '10110',
                'lat_alamat_pengiriman' => '-6.175687372353113',
                'long_alamat_pengiriman' => '106.82715243677141',
                'status_alamat_pengiriman' => 'Office',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'delete_alamat_pengiriman' => 'N',
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
            'provinsi_id' => 3,
            'kota_id' => 455,
            'kecamatan_id' => 6281,
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
                'stok_produk' => 80,
                'create_produk' => Carbon::now(),
                'delete_produk' => 'N',
            ],
        ]);
        DB::table('tb_foto_produk')->insert([
            [
                'id_produk' => 1,
                'file_foto_produk_1' => 'https://d23zpyj32c5wn3.cloudfront.net/images/distributions/picture_2s/36199/big/Motul_106944_2100_PERFORMANCE_15W-40_4L.png?1602575024',
                'file_foto_produk_2' => 'https://d23zpyj32c5wn3.cloudfront.net/pim/packshots/pictures/18/main/open-uri20211026-26319-fsfrpe?1635261829',
                'file_foto_produk_3' => 'https://d23zpyj32c5wn3.cloudfront.net/images/distributions/picture_2s/36199/big/Motul_106944_2100_PERFORMANCE_15W-40_4L.png?1602575024',
                'file_foto_produk_4' => null,
                'file_foto_produk_5' => null,
                'create_file_foto_produk' => Carbon::now(),
                'delete_file_foto_produk' => 'N',
            ],
            [
                'id_produk' => 2,
                'file_foto_produk_1' => 'https://d23zpyj32c5wn3.cloudfront.net/images/distributions/picture_2s/36199/big/Motul_106944_2100_PERFORMANCE_15W-40_4L.png?1602575024',
                'file_foto_produk_2' => 'https://www.motul.com/_next/image?url=https%3A%2F%2Fazupim01.motul.com%2Fmedia%2FmotulData%2FIM%2Fbigweb%2FMOTUL_110205_5000%252020W-50%25204T-1L%2520AL_NEW_png.png&w=1080&q=75',
                'file_foto_produk_3' => 'https://cdn2.louis.de/dynamic/articles/o_resize,w_1800,h_1800,m_limit,c_fff/c8.70.ee.10037638Motul30004T20W501l970DET0118.JPG',
                'file_foto_produk_4' => null,
                'file_foto_produk_5' => null,
                'create_file_foto_produk' => Carbon::now(),
                'delete_file_foto_produk' => 'N',
            ]
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
                'stok_spare_part' => 120,
                'create_spare_part' => Carbon::now(),
                'delete_spare_part' => 'N',
            ],
        ]);
        DB::table('tb_foto_spare_part')->insert([
            [
                'id_spare_part' => 1,
                'file_foto_spare_part_1' => 'https://www.fleet.boschautoparts.com/o/commerce-media/products/660569/workshop-air-filters/2228122/WorkshopAir_Category.png?download=true',
                'file_foto_spare_part_2' => 'https://tse2.mm.bing.net/th?id=OIP.5waTuDa8ew3WUGApVSCThQHaE6&pid=Api&P=0&h=180',
                'file_foto_spare_part_3' => 'https://tse2.mm.bing.net/th?id=OIP.5waTuDa8ew3WUGApVSCThQHaE6&pid=Api&P=0&h=180',
                'file_foto_spare_part_4' => null,
                'file_foto_spare_part_5' => null,
                'create_file_foto_spare_part' => Carbon::now(),
                'delete_file_foto_spare_part' => 'N',
            ],
            [
                'id_spare_part' => 2,
                'file_foto_spare_part_1' => 'https://tse3.mm.bing.net/th?id=OIP.f-Sxeiwjxd472kTMogXu9gHaIG&pid=Api&P=0&h=180',
                'file_foto_spare_part_2' => 'https://www.racingplanetusa.com/images/gross/dsw24frl_zuendkerze_denso_shop.jpg',
                'file_foto_spare_part_3' => 'https://tse3.mm.bing.net/th?id=OIP.iNLWpIVr2E9L5OpQSE06CwHaHa&pid=Api&P=0&h=180',
                'file_foto_spare_part_4' => null,
                'file_foto_spare_part_5' => null,
                'create_file_foto_spare_part' => Carbon::now(),
                'delete_file_foto_spare_part' => 'N',
            ]
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
