<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng post_reaction
     * Thả cảm xúc bài post
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_reaction', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id');
            $table->integer('post_id');
            $table->string('reaction_type')
                ->comment('reaction_type: kiểu cảm xúc như haha,love,...');

            $table->string('user_created')
                ->nullable();
            $table->string('user_updated')
                ->nullable();
            $table->string('user_deleted')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng post_reaction
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_reaction');
    }
};
