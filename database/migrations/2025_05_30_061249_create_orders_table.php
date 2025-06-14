<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // Thông tin người nhận
        $table->string('recipient_name');
        $table->string('recipient_phone');

        // Địa chỉ chi tiết
        $table->string('province');        // Tỉnh / Thành phố
        $table->string('district');        // Quận / Huyện
        $table->string('ward');            // Xã / Phường
        $table->string('address_detail');  // Số nhà, tên đường...

        // Phương thức thanh toán
        $table->enum('payment_method', ['cod', 'bank_transfer'])->default('cod');
        // cod = tiền mặt khi giao hàng, bank_transfer = chuyển khoản

        // Tổng tiền + trạng thái đơn hàng
        $table->integer('total_price');
        $table->string('status')->default('Chờ xác nhận');

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
