<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gallery_id')->unsigned();
            $table->string('name');
            $table->string('path');
            $table->string('extension', 10);
            $table->string('mime', 50);
            $table->integer('width');
            $table->integer('height');
            $table->integer('thumb_width');
            $table->integer('thumb_height');
            $table->integer('large_width');
            $table->integer('large_height');
            $table->integer('original_width');
            $table->integer('original_height');
            $table->integer('filesize');
            $table->string('title')->nullable()->default(null);
            $table->string('caption')->nullable()->default(null);
            $table->string('alt_text')->nullable()->default(null);
            $table->string('source')->nullable()->default(null);
            $table->string('credit')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->boolean('active')->default(false);
            $table->boolean('featured')->default(false);
            $table->integer('sequence')->default(99999999);
            $table->string('uploaded_by');
            $table->timestamps();

            $table->engine = 'InnoDB';

            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_images');
    }
}
