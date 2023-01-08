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
                ->nullable()
                ->comment('content: mô tả');
            $table->text('thumbnail')
                ->nullable()
                ->comment('thumbnail: hình ảnh đại diện');
            $table->boolean('status')
                ->nullable()
                ->default(Status::Inactive)
                ->comment('status: trạng thái hiện ẩn');
            $table->string('slug')
                ->nullable();
            $table->text('meta_keyword')
                ->nullable()
                ->comment('meta_keyword: tìm kiếm');

            $table->string('user_created')
                ->nullable()
                ->comment('user_created: người tạo bài viết');
            $table->string('user_updated')
                ->nullable()
                ->comment('user_updated: người cập nhật lại bài viết');
            $table->string('user_deleted')
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
