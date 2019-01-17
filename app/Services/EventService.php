<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Student;
use App\Letter;
use App\Event;

use App\Http\Controllers\Controller;

class EventService extends Controller
{
  public function make($event, $eventType)
  {
    $student = Student::firstOrCreate(
      ['student_id' => $event[2]],
      ['language' => 'English', 'grade' => $event[3]]);
    $event = Event::create([
     'event_date' => $event[1],
     'student_id' => $student->id,
     'event_type_id' => $eventType,
     'import_id' => $event[0],
     'semester_id' => 1 //TODO get id from date
    ]);
    return $event;
  }

  public function getStudentsNeeding($letter){
    // TODO need to figure out way to check the two event types for letter needed
    $letterNeeded =  Letter::find($letter)->toArray();
    $studentsWithLetters = DB::table('letter_student')
                    ->selectRaw('letter_student.student_id')
                    ->whereRaw('letter_id = ?', [$letter])
                    ->get()->pluck('student_id');
    $students = DB::table('students')
                    ->selectRaw('students.*, count(DISTINCT events.id) as event_count')
                    ->join('events', 'students.id', '=', 'events.student_id')
                    ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
                    ->whereRaw('events.deleted_at IS NULL AND event_types.letter_type = ?', [$letterNeeded['type']])
                    ->havingRaw('count(DISTINCT events.id) >= ?', [$letterNeeded['count']])
                    ->whereNotIn('students.id', $studentsWithLetters)
                    ->groupBy('students.id')
                    ->get();
      return $students;
  }
}
