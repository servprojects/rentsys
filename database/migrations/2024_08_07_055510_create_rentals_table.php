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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->dateTime('expected_pickup_datetime');
            $table->dateTime('expected_return_datetime');
            $table->dateTime('actual_pickup_datetime');
            $table->dateTime('actual_return_datetime');
            $table->dateTime('date_of_inquiry');
            $table->boolean('is_from_ads');
            $table->string('pickup_remarks');
            $table->string('return_remarks');
            $table->string('surrendered_id');
            $table->boolean('deleted')->default(false);
            $table->unsignedBigInteger('asset_id');
            $table->timestamps();

            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
