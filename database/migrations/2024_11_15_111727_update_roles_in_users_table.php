<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Đảm bảo cột role cho phép giá trị 'admin'
            $table->enum('role', ['user', 'landlord', 'admin'])->default('user')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Quay lại cấu trúc cũ nếu cần
            $table->enum('role', ['user', 'landlord'])->default('user')->change();
        });
    }
};