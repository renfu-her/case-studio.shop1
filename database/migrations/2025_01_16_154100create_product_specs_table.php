<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name')->comment('規格名稱');
            $table->decimal('price', 10, 2)->default(0)->comment('價格');
            $table->integer('stock')->default(0)->comment('庫存');
            $table->boolean('is_active')->default(true)->comment('啟用狀態');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specs');
    }
};
