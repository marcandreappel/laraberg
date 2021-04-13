<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlocksContentsTables extends Migration
{
    public function up()
    {
        Schema::create('laraberg_blocks', function (Blueprint $table) {
            $table->uuid('id')->index()->unique()->primary();
            $table->string('raw_title')->nullable();
            $table->text('raw_content')->nullable();
            $table->text('rendered_content')->nullable();
            $table->string('status');
            $table->string('slug');
            $table->string('type')->default('wp_block');
            $table->timestamps();
        });

        Schema::create('laraberg_contents', function (Blueprint $table) {
            $table->uuid('id')->index()->primary()->unique();
            $table->text('raw_content')->nullable();
            $table->text('rendered_content')->nullable();
            $table->uuidMorphs('contentable');
            $table->string('type')->default('page');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('laraberg_blocks');
        Schema::drop('laraberg_contents');
    }
}

