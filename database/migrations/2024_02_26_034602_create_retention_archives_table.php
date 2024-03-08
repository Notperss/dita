<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('retention_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_classification_id');
            $table->unsignedBigInteger('sub_classification_id');
            $table->string('sub_series');
            $table->string('period_active');
            $table->string('period_inactive');
            $table->longText('description_active')->nullable();
            $table->longText('description_inactive')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('main_classification_id')->references('id')->on('location_mains')->onDelete('cascade');
            $table->foreign('sub_classification_id')->references('id')->on('location_subs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('retention_archives');
    }
};
