<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('hired_at')->nullable();
            $table->boolean('active')->default(true);
            $table->string('contract_path')->nullable();
            $table->string('contract_original_name')->nullable();
            $table->timestamps();
        });

        Schema::create('class_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['class_id', 'staff_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('class_staff');
        Schema::dropIfExists('staff');
    }
};
