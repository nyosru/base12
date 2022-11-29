<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastDashboardOwnerRowView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // \DB::statement($this->dropView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // private function createView(): string
    // {
    //     return <<<SQL
    //         CREATE VIEW last_dashboard_owner_row_view AS
    //           select * from dashboard_owner where id in
    //             (SELECT max(id) FROM dashboard_owner group by dashboard_id)
    //         SQL;
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // private function dropView(): string
    // {
    //     return <<<SQL
    //         DROP VIEW IF EXISTS `last_dashboard_owner_row_view`;
    //         SQL;
    // }
}
