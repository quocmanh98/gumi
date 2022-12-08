<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng: image_posts
     * Upload nhiều ảnh bài posts lên server
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_posts', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('path')
                ->comment('path: đường dẫn ảnh');
            $table->integer('post_id');
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_posts');
    }
};
