<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng image_books
     * Upload nhiều ảnh của sách lên server
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_books', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('path')
                ->comment('path: đường dẫn ảnh');
            $table->integer('book_id');
            $table->boolean('status')
                ->default(Status::Inactive);

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
     * Xóa bảng: image_books
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_books');
    }
};
