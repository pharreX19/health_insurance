<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("episodes", function (Blueprint $table) {
            $table->id();
            $table->string("memo_number");
            $table->foreignId("subscriber_id")->constrained();
            // $table->foreignId("service_id")->constrained();
            $table->foreignId("service_provider_id")->constrained();
            $table->dateTime("activity_at")->default(Date('Y-m-d h:i:s'));
            $table->enum("status", ["pending", "completed", "cancelled"]);
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
        Schema::dropIfExists("episodes");
    }
}
