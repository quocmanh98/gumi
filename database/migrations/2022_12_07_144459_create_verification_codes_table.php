<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng: verification_codes
     * Lưu mã OTP được gửi qua cho user để xác nhận email
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verification_codes', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->string('otp')
                ->comment('otp: mã OTP');
            $table->string('email');

            $table->string('user_created')
                ->nullable();
            $table->string('user_updated')
                ->nullable();
            $table->string('user_deleted')
                ->nullable();

            $table->timestamp('expire_at')
                ->nullable()
                ->comment('expire_at: ngày hiệu lực token');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng: verification_codes
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verification_codes');
    }
};
