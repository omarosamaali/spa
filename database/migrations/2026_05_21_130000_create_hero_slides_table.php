<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->string('type')->default('image'); // image | video
            $table->string('media_url')->nullable();
            $table->string('media_path')->nullable();
            $table->string('media_url_alt')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('poster_path')->nullable();
            $table->string('badge')->nullable();
            $table->string('title')->nullable();
            $table->string('title_highlight')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('btn_primary_text')->nullable();
            $table->string('btn_primary_url')->nullable();
            $table->string('btn_secondary_text')->nullable();
            $table->string('btn_secondary_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
