<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceLimitGroupCalculationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("service_limit_group_calculation_types", function (Blueprint $table) {
            $table->id();
            $table->enum("name", ["annually", "monthly", "daily", "per-event"])->default("annually");
            $table->string("slug", 255)->nullable();
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
        Schema::dropIfExists("service_limit_group_calculation_types");
    }
}
