<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVLabaRugiView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView()
    {
        return <<<SQL
            CREATE VIEW `v_laba_rugi` AS select cast(`a`.`tanggal` as date) AS `tanggal`,'Penjualan' AS `keterangan`,'0' AS `nominal_debit`,`a`.`total_harga` AS `nominal_kredit` from `t_order` `a`
        SQL;
    }

    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_laba_rugi`;
        SQL;
    }
}
