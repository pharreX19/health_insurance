<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('service_id')->constrained();
            // $table->foreignId('service_limit_group_id')->nullable()->constrained();
            $table->unsignedBigInteger("limit_group_calculation_type_id")->nullable()->default(NULL);
            $table->foreign("limit_group_calculation_type_id")->references("id")->on("service_limit_group_calculation_types")->onDelete("set null");
            $table->decimal('limit_total', 10, 2)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('plan_service');
    }
}
