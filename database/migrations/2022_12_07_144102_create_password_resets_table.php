<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng password_resets
     * Lưu token được gửi qua cho user qua email
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {

            $table->id();
            $table->string('email')->index();
            $table->string('token');
            $table->integer('user_id');

            $table->integer('user_created')
                ->nullable();
            $table->integer('user_updated')
                ->nullable();
            $table->integer('user_deleted')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng: password_resets
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
