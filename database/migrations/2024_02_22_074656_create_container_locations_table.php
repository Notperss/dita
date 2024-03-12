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
        Schema::create('location_containers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_location_id');
            $table->unsignedBigInteger('sub_location_id');
            $table->unsignedBigInteger('detail_location_id');
            $table->unsignedBigInteger('division_id');
            $table->integer('number_container');
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('main_location_id')->references('id')->on('location_mains')->onDelete('cascade');
            $table->foreign('sub_location_id')->references('id')->on('location_subs')->onDelete('cascade');
            $table->foreign('detail_location_id')->references('id')->on('location_details')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('location_containers');
    }
};
