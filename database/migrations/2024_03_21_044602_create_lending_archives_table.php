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
        Schema::create('lending_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lending_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->unsignedBigInteger('archive_container_id');
            $table->tinyInteger('status')->default('1')->comment('1 = proses, 2 = pinjam, 3 = selesai pinjam');
            $table->tinyInteger('approval')->nullable()->comment('1 = Approved, 2 = Declined');
            $table->date('period')->nullable();
            $table->string('document_type');
            // $table->boolean('approval')->default(true);
            $table->timestamps();

            $table->foreign('lending_id')->references('id')->on('lendings')->onDelete('cascade');
            $table->foreign('archive_container_id')->references('id')->on('archive_containers')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('lending_archives');
    }
};
