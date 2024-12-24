<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVLabaRugiView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the view if it exists
        DB::statement($this->dropView());

        // Create the view
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the view if it exists
        DB::statement($this->dropView());
    }

    /**
     * SQL statement to create the view.
     *
     * @return string
     */
    private function createView()
    {
        return <<<SQL
        CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_laba_rugi` AS
        SELECT
            CAST(`t_order`.`tanggal` AS DATE) AS `tanggal`,
            'Penjualan Offline' AS `keterangan`,
            0 AS `nominal_debit`,
            `t_order`.`total_harga` AS `nominal_kredit`
        FROM `t_order`

        UNION ALL

        SELECT
            CAST(`t_order_online`.`tanggal` AS DATE) AS `tanggal`,
            'Penjualan Online' AS `keterangan`,
            0 AS `nominal_debit`,
            `t_order_online`.`total_harga` AS `nominal_kredit`
        FROM `t_order_online`

        UNION ALL

        SELECT
            `t_pengeluaran`.`tanggal` AS `tanggal`,
            'Pengeluaran' AS `keterangan`,
            `t_pengeluaran`.`nominal` AS `nominal_debit`,
            0 AS `nominal_kredit`
        FROM `t_pengeluaran`;
    SQL;
    }

    /**
     * SQL statement to drop the view.
     *
     * @return string
     */
    private function dropView()
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_laba_rugi`;
        SQL;
    }
}
