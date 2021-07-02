<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId("episode_id")->constrained();
            $table->foreignId("service_id")->constrained();
            $table->decimal("insurance_covered_limit", 10, 2);
            $table->decimal("aasandha_covered_limit", 10, 2);
            $table->decimal("self_covered_limit", 10, 2);
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
        Schema::dropIfExists('episode_services');
    }
}
