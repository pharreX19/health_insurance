<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceLimitGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_limit_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('slug', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->decimal('limit_total', 10, 2);
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
        Schema::dropIfExists('service_limit_groups');
    }
}
