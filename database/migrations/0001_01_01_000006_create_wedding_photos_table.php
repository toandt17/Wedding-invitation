<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wedding_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_card_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->enum('type', ['gallery', 'featured', 'cover', 'bride', 'groom']); // gallery: ảnh album, featured: ảnh nổi bật, cover: ảnh bìa, bride: ảnh cô dâu, groom: ảnh chú rể
            $table->text('description')->nullable(); // Mô tả cho ảnh
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_photos');
    }
};
