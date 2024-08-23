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
       

        Schema::create('company', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('country_code')->nullable();
            $table->string('region_code')->nullable();
            $table->string('municipality_code')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('location_coordinates')->nullable();
            $table->boolean('deleted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
