<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng: book_types
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_types', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('content')
                ->comment('content: mô tả');
            $table->string('thumbnail')
                ->comment('thumbnail: hình ảnh đại diện');
            $table->boolean('status')
                ->default(Status::Inactive)
                ->comment('status: trạng thái hiện ẩn');
            $table->string('slug');
            $table->text('meta_keyword')
                ->nullable()
                ->comment('meta_keyword: tìm kiếm');

            $table->integer('user_created')
                ->nullable()
                ->comment('user_created: người tạo bài viết');
            $table->integer('user_updated')
                ->nullable()
                ->comment('user_updated: người cập nhật lại bài viết');
            $table->integer('user_deleted')
                ->nullable()
                ->comment('user_deleted: người xóa bài viết');

            $table->timestamps();
            $table->softDeletes()
                ->comment('softDeletes: xóa mềm');

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng book_types
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_types');
    }
};
