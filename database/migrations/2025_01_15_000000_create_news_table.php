<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('weather_condition', ['hujan', 'banjir', 'kemacetan', 'kepadatan', 'normal', 'info']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('news_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained()->onDelete('cascade');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_locations');
        Schema::dropIfExists('news');
    }
};
