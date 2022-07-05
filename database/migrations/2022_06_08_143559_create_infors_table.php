<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInforsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->string('ph', 10);
            $table->string('temperature', 10);
            $table->string('turbidity', 10);
            $table->string('do', 10);
            $table->string('bod', 10);
            $table->string('cod', 10);
            $table->string('nh4', 10);
            $table->string('po4', 10);
            $table->string('tss', 10);
            $table->string('coliform', 10);
            $table->string('wqi', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infors');
    }
}
