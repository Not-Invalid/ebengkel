<?php

use Illuminate\Database\Migrations\Migration;
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
            SELECT CAST(`a`.`tanggal` AS DATE) AS `tanggal`,
                   'Penjualan' AS `keterangan`,
                   '0' AS `nominal_debit`,
                   `a`.`total_harga` AS `nominal_kredit`
            FROM `t_order` AS `a`;
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
