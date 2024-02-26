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
            $table->bigInteger('main_classification_id');
            $table->bigInteger('sub_classification_id');
            $table->string('sub_series');
            $table->string('retention_period');
            $table->longText('description')->nullable();
            $table->timestamps();
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
