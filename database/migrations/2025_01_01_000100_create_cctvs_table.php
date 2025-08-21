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
            $table->enum('camera_type', ['PTZ','Fix'])->default('Fix');
            $table->enum('status', ['Active','Inactive'])->default('Active');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->string('hls_url')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('cctvs');
    }
};