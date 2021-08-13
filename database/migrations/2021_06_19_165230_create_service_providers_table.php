<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("service_providers", function (Blueprint $table) {
            $table->id();
            $table->string("name", 255)->unique();
            $table->string("contact", 20)->nullable();
            $table->string("address", 255)->nullable();
            $table->string("street", 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("service_providers");
    }
}
