<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('free_shippings', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_amount', 10, 2)->comment('最低訂單金額');
            $table->timestamp('start_at')->nullable()->comment('開始時間');
            $table->timestamp('end_at')->nullable()->comment('結束時間');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('free_shippings');
    }
};
