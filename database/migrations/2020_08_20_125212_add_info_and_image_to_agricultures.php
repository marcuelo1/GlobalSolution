<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoAndImageToAgricultures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agricultures', function (Blueprint $table) {
            $table->text('Info');
            $table->string('Image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agricultures', function (Blueprint $table) {
            $table->dropColumn('Info');
            $table->dropColumn('Image');
        });
    }
}
