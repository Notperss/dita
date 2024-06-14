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
        Schema::create('classification_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_classification_id');
            $table->unsignedBigInteger('company_id');
            $table->string('code');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('main_classification_id')->references('id')->on('classification_mains')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('classifications_subs');
    }
};
