<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_pelanggan')->insert([
            [
                'nama_pelanggan' => 'John Doe',
                'telp_pelanggan' => '081234567890',
                'email_pelanggan' => 'raffli.doktortj@gmail.com',
                'password_pelanggan' => Hash::make('password'), // Menggunakan Hash untuk enkripsi password
                'password_reset_token' => null,
                'foto_pelanggan' => null,
                'role_pelanggan' => 'pembeli',
                'status_pelanggan' => 'Aktif',
                'created_pelanggan' => Carbon::now(),
                'updated_pelanggan' => Carbon::now(),
                'delete_pelanggan' => 'N',
            ],
        ]);
    }
}
