<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateVwTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW `vw_tasks` AS
            SELECT
                `tasks`.`id` AS `id`,
                `tasks`.`project_id` AS `project_id`,
                `projects`.`project` AS `project`,
                `users`.`name` AS `name`,
                `tasks`.`task` AS `task`,
                `tasks`.`paid` AS `paid`,
                `users`.`email` AS `email`,
                DATE_FORMAT(`tasks`.`start_datetime`,
                        '%d/%m/%Y - %H:%i:%s') AS `start_datetime`,
                DATE_FORMAT(`tasks`.`end_datetime`,
                        '%d/%m/%Y - %H:%i:%s') AS `end_datetime`,
                TIMESTAMPDIFF(HOUR,
                    `tasks`.`start_datetime`,
                    `tasks`.`end_datetime`) AS `total_hours`,
                TIMESTAMPDIFF(MINUTE,
                    `tasks`.`start_datetime` + INTERVAL TIMESTAMPDIFF(HOUR,
                        `tasks`.`start_datetime`,
                        `tasks`.`end_datetime`) HOUR,
                    `tasks`.`end_datetime`) AS `total_minutes`,
                TIMESTAMPDIFF(SECOND,
                    `tasks`.`start_datetime` + INTERVAL TIMESTAMPDIFF(MINUTE,
                        `tasks`.`start_datetime`,
                        `tasks`.`end_datetime`) MINUTE,
                    `tasks`.`end_datetime`) AS `total_seconds`
            FROM
                ((`tasks`
                LEFT JOIN `projects` ON (`tasks`.`project_id` = `projects`.`id`))
                LEFT JOIN `users` ON (`projects`.`user_id` = `users`.`id`))
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW vw_tasks');
    }
}
