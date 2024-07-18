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
            $table->unsignedBigInteger('company_id');

            $table->string('number_container')->nullable();
            $table->string('main_location')->nullable();
            $table->string('sub_location')->nullable();
            $table->string('detail_location')->nullable();
            $table->string('description_location')->nullable();

            $table->unsignedBigInteger('main_classification_id');
            $table->unsignedBigInteger('sub_classification_id');
            // $table->string('subseries');
            $table->string('period_active')->nullable();
            $table->string('period_inactive')->nullable();
            $table->string('expiration_active')->nullable();
            $table->string('expiration_inactive')->nullable();
            $table->longText('description_active')->nullable();
            $table->longText('description_inactive')->nullable();
            $table->longText('description_retention')->nullable();

            $table->string('number_app')->nullable();
            $table->string('number_catalog')->nullable();
            $table->string('number_document')->nullable();
            $table->string('number_archive')->nullable();
            $table->longText('regarding')->nullable();
            $table->longText('tag')->nullable();
            $table->string('document_type');
            $table->string('archive_type');
            $table->string('amount')->nullable();
            $table->date('archive_in');
            $table->year('year');
            $table->longText('file')->nullable();
            $table->longText('content_file')->nullable();

            $table->tinyInteger('status')->default('1')->comment('1 = Available, 2 = lend,');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
