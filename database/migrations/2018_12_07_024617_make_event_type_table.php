<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEventTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('letter_type');
            $table->string('name');
        });
        // Insert some stuff
        DB::table('event_types')->insert(
          array(
            array(
                'name' => 'Absent',
                'letter_type' => 1
            ),
            array(
                'name' => 'Tardy',
                'letter_type' => 2
            ),
            array(
                'name' => 'Early Dismissal',
                'letter_type' => 2
            )
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
        Schema::dropIfExists('event_types');
    }
}
