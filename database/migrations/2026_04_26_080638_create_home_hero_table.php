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
    Schema::create('home_hero', function (Blueprint $table) {
        $table->id();
        $table->string('bg_image');
        $table->text('title_text');
        $table->string('card_image');
        $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
    });
}

public function down(): void
{
    Schema::dropIfExists('home_hero');
}
};
