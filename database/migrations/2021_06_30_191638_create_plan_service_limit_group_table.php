<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanServiceLimitGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_service_limit_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId("service_limit_group_id")->constrained();
            $table->foreignId("plan_id")->constrained();
            $table->decimal("limit_total", 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_service_limit_groups');
    }
}
