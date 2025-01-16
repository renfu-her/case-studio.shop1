<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable()->comment('網站名稱');
            $table->string('title')->nullable()->comment('預設標題');
            $table->string('description')->nullable()->comment('預設描述');
            $table->string('keywords')->nullable()->comment('預設關鍵字');
            $table->string('og_image')->nullable()->comment('預設 OG 圖片');
            $table->string('ga_id')->nullable()->comment('Google Analytics ID');
            $table->string('gtm_id')->nullable()->comment('Google Tag Manager ID');
            $table->text('custom_tags')->nullable()->comment('自定義標籤');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
}; 