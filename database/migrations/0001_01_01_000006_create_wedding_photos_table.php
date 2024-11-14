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
            $table->enum('type', ['gallery', 'featured']); // gallery: ảnh album, featured: ảnh nổi bật
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
