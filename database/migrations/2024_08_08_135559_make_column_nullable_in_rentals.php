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
        Schema::table('rentals', function (Blueprint $table) {
            $table->dateTime('actual_pickup_datetime')->nullable()->change();
            $table->dateTime('actual_return_datetime')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dateTime('actual_pickup_datetime')->nullable(false)->change();
            $table->dateTime('actual_return_datetime')->nullable(false)->change();
        });
    }
};
