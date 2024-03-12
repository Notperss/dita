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
            $table->unsignedBigInteger('division_id');
            $table->string('number_container');
            $table->string('main_location');
            $table->string('sub_location');
            $table->string('detail_location');
            $table->string('description_location');

            $table->unsignedBigInteger('main_classification_id');
            $table->unsignedBigInteger('sub_classification_id');

            $table->string('subseries');
            $table->string('period_active');
            $table->string('period_inactive');
            $table->string('expiration_active');
            $table->string('expiration_inactive');
            $table->longText('description_active');
            $table->longText('description_inactive');
            $table->longText('description_retention');

            $table->string('number_app');
            $table->string('number_catalog');
            $table->string('number_document');
            $table->string('number_archive');
            $table->longText('regarding');
            $table->longText('tag');
            $table->string('document_type');
            $table->string('archive_type');
            $table->string('amount');
            $table->date('archive_in');
            $table->year('year');
            $table->longText('file');
            $table->longText('content_file');

            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('main_classification_id')->references('id')->on('classification_mains')->onDelete('cascade');
            $table->foreign('sub_classification_id')->references('id')->on('classification_subs')->onDelete('cascade');

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
