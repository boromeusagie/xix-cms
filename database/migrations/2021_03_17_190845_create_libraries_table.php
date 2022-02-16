<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('path')->unique();
            $table->text('name');
            $table->boolean('directory')->default('FALSE');
            $table->integer('size')->nullable();
            $table->string('file_type');
            $table->string('alt_text')->nullable();
            // UNIX style file permissions:
            // Digit order: user, group, all
            // 0: -
            // 1: read
            // 2: read write
            $table->integer('permissions')->default('221');
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('libraries')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libraries');
    }
}
