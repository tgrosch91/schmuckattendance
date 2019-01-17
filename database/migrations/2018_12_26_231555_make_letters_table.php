<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('count');
            $table->integer('type');
        });
        // Insert some stuff
        DB::table('letters')->insert(
          array(
            array(
                'name' => 'Three Days Absent',
                'count' => 3,
                'type' => 1
            ),
            array(
                'name' => 'Five Days Absent',
                'count' => 5,
                'type' => 1
            ),
            array(
                'name' => 'Seven Days Absent',
                'count' => 7,
                'type' => 1
            ),
            array(
                'name' => 'Ten Days Absent',
                'count' => 10,
                'type' => 1
            ),
            array(
                'name' => 'Five Days Tardy / ED',
                'count' => 5,
                'type' => 2
            ),
            array(
                'name' => 'Ten Days Tardy / ED',
                'count' => 10,
                'type' => 2
            ),
            array(
                'name' => 'Fifteen Days Tardy / ED',
                'count' => 15,
                'type' => 2
            ),
          )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('letters');
    }
}
