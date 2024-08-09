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
            $table->dateTime('date_of_inquiry')->nullable()->change();
            $table->boolean('is_from_ads')->nullable()->change(); 
            $table->string('pickup_remarks')->nullable()->change(); 
            $table->string('return_remarks')->nullable()->change(); 
            $table->string('surrendered_id')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dateTime('date_of_inquiry')->nullable(false)->change();
            $table->boolean('is_from_ads')->nullable(false)->change(); 
            $table->string('pickup_remarks')->nullable(false)->change(); 
            $table->string('return_remarks')->nullable(false)->change(); 
            $table->string('surrendered_id')->nullable(false)->change(); 
        });
    }
};
