<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWeightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->integer('calories')->nullable()->after('weight');
            $table->integer('exercise_time')->nullable()->after('calories');
            $table->text('exercise_content')->nullable()->after('exercise_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weight_logs', function (Blueprint $table) {
            $table->dropColumn(['calories', 'exercise_time', 'exercise_content']);
        });
    }
}
