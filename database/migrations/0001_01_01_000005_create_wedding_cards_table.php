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
            $table->string('couple_email')->nullable();

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
            $table->dateTime('lunar_wedding_date');
            $table->time('party_time');
            $table->string('venue_name');
            $table->text('venue_address');
            $table->text('google_map_iframe')->nullable();
            $table->text('google_map')->nullable();

            // Nội dung
            $table->text('wedding_poem')->nullable();
            $table->string('qr_code')->nullable();

            $table->decimal('price', 10, 2)->nullable()->default(0); // Giá thiệp
            $table->boolean('is_free')->default(false); // Nhãn "miễn phí"
            $table->boolean('is_hot')->default(false); // Nhãn "hot"

            // Thông tin thanh toán
            $table->string('bank_account_name')->nullable(); // Tên chủ tài khoản
            $table->string('bank_account_number')->nullable(); // Số tài khoản
            $table->string('bank_name')->nullable(); // Tên ngân hàng

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_image')->nullable();

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
