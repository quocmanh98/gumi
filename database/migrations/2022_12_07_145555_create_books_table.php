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
                ->comment('views: lượt xem');
            $table->string('thumbnail');
            $table->string('author')
                ->comment('author: tác giả');
            $table->string('quantity')
                ->comment('quantity: số lượng');
            $table->string('price_old');
            $table->string('price_new');
            $table->string('slug');
            $table->string('supplier')
                ->comment('supplier: nhà cung cấp');
            $table->string('publishing_company')
                ->comment('publishing_company: nhà xuất bản');
            $table->string('cover')
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
     * Xóa bảng books
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
