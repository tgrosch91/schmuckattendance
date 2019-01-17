<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->date('event_date');
            $table->integer('semester_id')->unsigned()->index();
            $table->integer('student_id')->unsigned()->index();
            $table->integer('event_type_id')->unsigned()->index();
            $table->integer('import_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('import_id')->references('id')->on('imports')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
