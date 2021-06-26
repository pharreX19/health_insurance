<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_subscriber', function (Blueprint $table) {
            $table->id();
            $table->decimal('plan_remaining', 10, 2);
            $table->date('begin_date')->default(Date('Y-m-d'));
            $table->date('expiry_date')->default(Carbon::now()->addYear()->toDateString());
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('subscriber_id')->constrained();
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
        Schema::dropIfExists('plan_subscriber');
    }
}
