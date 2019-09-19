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

   public function getStudentsConsecutiveDays($letter){
    $letterNeeded =  Letter::find($letter)->toArray();
    $studentsWithLetters = DB::table('letter_student')
                    ->selectRaw('letter_student.student_id')
                    ->whereRaw('letter_id = ?', [$letter])
                    ->get()->pluck('student_id');
    // Get all students with either at least 3 absences or at least 10 depending on $letterNeeded['count]
    // Then for each student pull all the event dates and put them into an array, then run the array through
    // a function that will tell me if there are consecutive ones
    $studentsWithMinimum = DB::table('students')
                    ->selectRaw('students.*, count(DISTINCT events.id) as event_count')
                    ->join('events', 'students.id', '=', 'events.student_id')
                    ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
                    ->whereRaw('events.deleted_at IS NULL AND event_types.letter_type = ?', [$letterNeeded['type']])
                    ->havingRaw('count(DISTINCT events.id) >= ?', [$letterNeeded['count']])
                    ->whereNotIn('students.id', $studentsWithLetters)
                    ->groupBy('students.id')
                    ->get();
    $students = [];
    foreach($studentsWithMinimum as $student){
      $events = DB::table('events')
                    ->selectRaw('events.event_date')
                    ->join('students', 'students.id', '=', 'events.student_id')
                    ->whereRaw('events.event_type_id = ?', [$letterNeeded['type']])
                    ->whereRaw('events.deleted_at IS NULL AND students.id = ?', [$student->id])
                    ->orderBy('events.event_date', 'ASC')
                    ->get();

      $consecutiveEvents = $this->checkConsecutiveDays($events, $letterNeeded['count']);  
    
      if (count($consecutiveEvents) > 0){
        $consecutiveEventsStrings = [];
        foreach($consecutiveEvents as $consecutiveEvent){
          $consecutiveString = implode(', ', $consecutiveEvent);
          $consecutiveEventsStrings[] = $consecutiveString;
        }
        $student->event_count = implode(' AND ', $consecutiveEventsStrings);
        $students[] = $student;
      }         
    }
    return $students;
  }

  private function checkConsecutiveDays($events, $count){
    $allGroupings = [];
    $consecutiveGrouping = [];
    foreach($events as $key=>$event){
      if ($key > 0){
        $current = new \DateTime($event->event_date);
        $previous = new \DateTime($events[$key-1]->event_date);
        $currentIsMonday = $current->format('N') == 1;
        $previousIsFriday = $previous->format('N') == 5;
        $diff = $current->diff($previous);
        // If the difference is exactly 1 day or the current day is Monday and the previous day is the previous Friday
        if ($diff->days === 1 || ($currentIsMonday && $previousIsFriday && $diff->days < 4)) {
            if(!in_array($previous->format('Y-m-d'), $consecutiveGrouping)){
              $consecutiveGrouping[] = $previous->format('Y-m-d');
            }
            $consecutiveGrouping[] = $current->format('Y-m-d');
            if($key === count($events) -1 && count($consecutiveGrouping) >= $count){
              $allGroupings[] = $consecutiveGrouping;
            }
        } else {
          if(count($consecutiveGrouping) >= $count){
            $allGroupings[] = $consecutiveGrouping;
          }
          $consecutiveGrouping = [];
        }
      }
    }
    return $allGroupings;
  }

}
