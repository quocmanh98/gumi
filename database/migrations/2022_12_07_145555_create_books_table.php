<?php

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tạo bảng books
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('content')
                ->comment('content: nội dung');
            $table->string('views')
                ->nullable()
                ->comment('views: lượt xem');
            $table->text('thumbnail')
                ->nullable();
            $table->string('author')
                ->nullable()
                ->comment('author: tác giả');
            $table->string('quantity')
                ->nullable()
                ->comment('quantity: số lượng');
            $table->string('price_old')
                ->nullable();
            $table->string('price_new')
                ->nullable();
            $table->string('slug')
                ->nullable();
            $table->string('supplier')
                ->nullable()
                ->comment('supplier: nhà cung cấp');
            $table->string('publishing_company')
                ->nullable()
                ->comment('publishing_company: nhà xuất bản');
            $table->string('cover')
                ->nullable()
                ->comment('hình thức bìa: bìa cứng, bìa mềm');
            $table->boolean('status')
                ->default(Status::Inactive)
                ->comment('status: trạng thái ẩn hiện');
            $table->text('tags')
                ->nullable()
                ->comment('tags: thẻ books');
            $table->text('meta_keyword')
                ->nullable()
                ->comment('meta_keyword: tìm kiếm');
            $table->integer('type_id');

            $table->string('user_created')
                ->nullable();
            $table->string('user_updated')
                ->nullable();
            $table->string('user_deleted')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     * Xóa bảng books
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
