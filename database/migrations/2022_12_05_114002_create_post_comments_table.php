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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->foreignId('post_id')
            ->nullable()
            ->constrained('posts')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->text('reply_id')->nullable();
            $table->boolean('status')->default(1)->nullable();
            
            $table->timestamps();
            $table->text('user_created')->nullable();
            $table->text('user_updated')->nullable();
            $table->text('user_deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comments');
    }
};
