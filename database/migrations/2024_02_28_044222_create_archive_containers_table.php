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
        Schema::create('archive_containers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('division_id');
            $table->string('number_container');
            $table->string('main_location');
            $table->string('sub_location');
            $table->string('detail_location');
            $table->string('description_location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('archive_containers');
    }
};
