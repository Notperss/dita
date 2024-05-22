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
        Schema::create('folder_item_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folder_item_id');
            $table->unsignedBigInteger('folder_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->string('file');
            $table->timestamps();

            $table->foreign('folder_item_id')->references('id')->on('folder_items')->onDelete('cascade');
            $table->foreign('folder_id')->references('id')->on('folder_divisions')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('folder_item_files');
    }
};
