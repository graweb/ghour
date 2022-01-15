<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW `vw_projects` AS
            SELECT
                `projects`.`id` AS `id`,
                `projects`.`user_id` AS `user_id`,
                `users`.`name` AS `name`,
                `users`.`email` AS `email`,
                `projects`.`project` AS `project`,
                `projects`.`hour_value` AS `hour_value`,
                `projects`.`status` AS `status`,
                `projects`.`created_at` AS `created_at`
            FROM
                (`projects`
                LEFT JOIN `users` ON (`users`.`id` = `projects`.`user_id`))
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW vw_projects');
    }
}
