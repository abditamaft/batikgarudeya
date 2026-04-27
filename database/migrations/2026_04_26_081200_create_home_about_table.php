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
        Schema::create('home_about', function (Blueprint $table) {
            $table->id();
            $table->text('text_top_left')->nullable();
            $table->string('image_bottom_left')->nullable();
            $table->string('image_top_right')->nullable();
            $table->text('text_bottom_right')->nullable();
            $table->string('visi_misi_button_link')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_about');
    }
};
