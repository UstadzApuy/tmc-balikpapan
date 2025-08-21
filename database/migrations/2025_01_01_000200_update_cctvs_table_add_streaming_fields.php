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
        Schema::table('cctvs', function (Blueprint $table) {
            $table->string('hls_url')->nullable()->after('rtsp_url');
            $table->boolean('is_streaming')->default(false)->after('hls_url');
            $table->timestamp('last_stream_check')->nullable()->after('is_streaming');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cctvs', function (Blueprint $table) {
            $table->dropColumn(['hls_url', 'is_streaming', 'last_stream_check']);
        });
    }
};
