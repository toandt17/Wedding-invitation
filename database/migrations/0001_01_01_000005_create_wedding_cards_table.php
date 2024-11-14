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
        Schema::create('wedding_cards', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('template_id');
            $table->foreignId('wedding_music_id')->nullable()->constrained('wedding_music')->nullOnDelete();

            // Thông tin cơ bản
            $table->string('groom_name');
            $table->string('bride_name');

            // Ảnh đại diện
            $table->string('cover_image');
            $table->string('groom_image');
            $table->string('bride_image');

            // Thông tin gia đình
            $table->string('groom_father_name');
            $table->string('groom_mother_name');
            $table->string('bride_father_name');
            $table->string('bride_mother_name');

            // Thời gian và địa điểm
            $table->dateTime('wedding_date');
            $table->string('venue_name');
            $table->text('venue_address');
            $table->text('google_map_iframe')->nullable();

            // Nội dung
            $table->text('wedding_poem')->nullable();
            $table->string('qr_code')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_cards');
        Schema::table('wedding_cards', function (Blueprint $table) {
            $table->dropForeign(['wedding_music_id']);
            $table->dropColumn('wedding_music_id');
        });
    }
};
