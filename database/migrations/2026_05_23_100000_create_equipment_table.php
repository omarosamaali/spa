<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('service_staff', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->primary(['service_id', 'staff_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('equipment_id')->nullable()->after('category')->constrained('equipment')->nullOnDelete();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedSmallInteger('duration_minutes')->nullable()->after('service_id');
            $table->foreignId('equipment_id')->nullable()->after('staff_id')->constrained('equipment')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('equipment_id');
            $table->dropColumn('duration_minutes');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('equipment_id');
        });

        Schema::dropIfExists('service_staff');
        Schema::dropIfExists('equipment');
    }
};
