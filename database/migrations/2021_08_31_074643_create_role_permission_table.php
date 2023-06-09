<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration {
    /**
     * Tạo bảng trung gian: role_permission
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->nullable();
            $table->foreignId('permission_id')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Xóa bảng trung gian: role_permission
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('role_permissions');
    }
}
