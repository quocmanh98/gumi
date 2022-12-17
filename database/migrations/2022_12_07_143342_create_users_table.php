<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng users
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->string('name')
                ->comment('name: họ tên người dùng');
            $table->string('username')
                ->comment('username: tên người dùng');
            $table->string('email');
            $table->string('password');
            $table->string('gender')
                ->comment('gender: Giới tính')
                ->nullable();
            $table->string('phone')
                ->nullable();
            $table->text('address')
                ->nullable();
            $table->string('thumbnail')
                ->comment('thumbnail: Hình ảnh đại diện ')
                ->nullable();
            $table->boolean('status')
                ->default(Status::Inactive)
                ->comment('status: trạng thái tài khoản');
            $table->string('activation_date')
                ->nullable()
                ->comment('activate_date: ngày kích hoạt');
            $table->string('uuid')
                ->nullable();
            $table->timestamp('email_verified_at')
                ->nullable()
                ->comment('email_verified_at: email xác thực');
            $table->string('google_id')
                ->nullable();
            $table->foreignId('role_id')
                ->nullable();

            $table->integer('user_created')
                ->nullable();
            $table->integer('user_updated')
                ->nullable();
            $table->integer('user_deleted')
                ->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng users
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
