<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng: posts
     * Bài post viết giới thiệu về sách
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('slug');
            $table->string('thumbnail');
            $table->string('meta_keyword')
                ->comment('meta_keyword: tìm kiếm');
            $table->boolean('status')
                ->default(Status::Inactive);
            $table->integer('book_id');
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
     * Xóa bảng posts
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
