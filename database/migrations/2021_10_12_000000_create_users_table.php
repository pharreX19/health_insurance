<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            // $table->string('user_type')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->string('contact', 10)->nullable();
            $table->boolean('active')->default(false);
            $table->decimal('amount', 10, 2)->default(0.0);
            $table->string('password');
            $table->foreignId('role_id')->constrained();
            // $table->foreignId('service_provider_id')->nullable()->constrained();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
