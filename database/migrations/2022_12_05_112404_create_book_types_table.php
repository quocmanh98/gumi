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
        Schema::create('book_types', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('slug')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('user_created')->nullable();
            $table->text('user_updated')->nullable();
            $table->text('user_deleted')->nullable();
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
        Schema::dropIfExists('book_types');
    }
};