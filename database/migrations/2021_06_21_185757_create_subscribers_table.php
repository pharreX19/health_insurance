<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('passport')->nullable()->unique();
            $table->string('national_id')->nullable()->unique()->index();
            $table->string("work_permit")->nullable()->index()->unique();
            $table->string('country')->default('Maldives');
            $table->string('contact')->nullable();
            // $table->string('policy_number');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete("set null");
            $table->foreignId('plan_id')->nullable()->constrained()->onDelete("set null");
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
        Schema::dropIfExists('employees');
    }
}
