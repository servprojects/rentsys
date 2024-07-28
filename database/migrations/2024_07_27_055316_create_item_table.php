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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_generic_name_id');
            $table->unsignedBigInteger('item_category_id');
            $table->unsignedBigInteger('item_brand_id');
            $table->string('description');
            $table->string('details')->nullable();
            $table->string('model');
            $table->timestamps();

            $table->foreign('item_generic_name_id')->references('id')->on('item_generic_names')->onDelete('cascade');
            $table->foreign('item_category_id')->references('id')->on('item_categories')->onDelete('cascade');
            $table->foreign('item_brand_id')->references('id')->on('item_brands')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
