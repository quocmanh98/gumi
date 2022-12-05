<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->text('fullname')->nullable();
            $table->text('username')->nullable()->index();
            $table->text('email')->nullable()->unique();
            $table->text('gender')->nullable()->unique();
            $table->boolean('status')->default(1)->nullable();
            $table->text('phone')->nullable();
            $table->text('thumbnail')->nullable();
            $table->text('uniqueId')->nullable();
            $table->text('activate_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('google_id')->nullable();
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
};
