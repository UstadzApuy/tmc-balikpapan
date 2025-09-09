<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('cctvs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('rtsp_url')->nullable();
            $table->string('hls_url')->nullable(); // digabung langsung
            $table->boolean('is_streaming')->default(false); // tambahan dari update
            $table->timestamp('last_stream_check')->nullable(); // tambahan dari update
            $table->enum('camera_type', ['PTZ','Fix'])->default('Fix');
            $table->enum('status', ['Active','Inactive'])->default('Active');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('cctvs');
    }
};
