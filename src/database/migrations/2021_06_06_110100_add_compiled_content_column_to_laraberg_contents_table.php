<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompiledContentColumnToLarabergContentsTable extends Migration
{
    public function up()
    {
        Schema::table('laraberg_contents', function (Blueprint $table) {
            $table->text('compiled_content')->nullable()->default(null);
        });
    }

    public function down()
    {
    }
}

