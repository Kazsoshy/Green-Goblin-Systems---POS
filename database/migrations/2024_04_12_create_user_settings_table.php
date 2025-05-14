<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('font_size', ['small', 'medium', 'large'])->default('medium');
            $table->boolean('high_contrast')->default(false);
            $table->boolean('reduce_motion')->default(false);
            $table->enum('theme_color', ['default', 'purple', 'green', 'blue'])->default('default');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}; 