<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_forecasts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->datetime('datetime');
            $table->string('status');
            $table->decimal('temperature', 8, 2);
            $table->string('weather_system');
            // Можно добавьте другие необходимые поля для хранения данных о прогнозе погоды

            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('tracked_locations')->onDelete('cascade');
            $table->index(['datetime', 'location_id']);
            $table->index(['datetime', 'weather_system']);
            $table->unique(['datetime', 'weather_system']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_forecasts');
    }
};
