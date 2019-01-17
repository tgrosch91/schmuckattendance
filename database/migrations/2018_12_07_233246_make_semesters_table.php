<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('semester_start');
            $table->dateTime('semester_end');
        });
        // Insert some stuff
        DB::table('semesters')->insert(
          array(
            array(
                'name' => 'Spring 2019',
                'semester_start' => '2019-01-01 00:00:00',
                'semester_end' => '2019-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2019',
                'semester_start' => '2019-08-01 00:00:00',
                'semester_end' => '2019-12-25 23:59:59'
            ),
            array(
                'name' => 'Spring 2020',
                'semester_start' => '2020-01-01 00:00:00',
                'semester_end' => '2020-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2020',
                'semester_start' => '2020-08-01 00:00:00',
                'semester_end' => '2020-12-25 23:59:59'
            ),
            array(
                'name' => 'Spring 2021',
                'semester_start' => '2021-01-01 00:00:00',
                'semester_end' => '2021-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2021',
                'semester_start' => '2021-08-01 00:00:00',
                'semester_end' => '2021-12-25 23:59:59'
            ),
            array(
                'name' => 'Spring 2022',
                'semester_start' => '2022-01-01 00:00:00',
                'semester_end' => '2022-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2022',
                'semester_start' => '2022-08-01 00:00:00',
                'semester_end' => '2022-12-25 23:59:59'
            ),
            array(
                'name' => 'Spring 2023',
                'semester_start' => '2023-01-01 00:00:00',
                'semester_end' => '2023-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2023',
                'semester_start' => '2023-08-01 00:00:00',
                'semester_end' => '2023-12-25 23:59:59'
            ),
            array(
                'name' => 'Spring 2024',
                'semester_start' => '2024-01-01 00:00:00',
                'semester_end' => '2024-06-15 23:59:59'
            ),
            array(
                'name' => 'Fall 2024',
                'semester_start' => '2024-08-01 00:00:00',
                'semester_end' => '2024-12-25 23:59:59'
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
        Schema::dropIfExists('semesters');
    }
}
