<?php

namespace App\Http\Controllers\Api;

use App\Student;
use App\Event;
use App\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAbsences()
    {
      $students = DB::table('students')
                      ->selectRaw('DISTINCT students.id')
                      ->join('events', 'students.id', '=', 'events.student_id')
                      ->where('events.event_type_id', 1)
                      ->get();
      $studentsArray = [];

      foreach($students as $key => $stud){
        $student = Student::find($stud->id);
        $events = $student->event()->where('event_type_id', 1)->get()->toArray();
        $letters = $student->letters->toArray();
        $studentArray = $student->toArray();
        $studentArray['count'] = "*" . count($events) . "*";
        $studentArray['event'] = $events;
        $studentArray['letter_count'] = "-" . count($letters) . "-";
        $studentArray['grade'] = "~" . $studentArray['grade'] . "~";
        $studentArray['edit'] = "Edit";
        $studentsArray[] = $studentArray;
      }
      return response()->json($studentsArray);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClassTardies()
    {
      $students = DB::table('students')
                      ->selectRaw('DISTINCT students.id')
                      ->join('events', 'students.id', '=', 'events.student_id')
                      ->whereIn('events.event_type_id', [4])
                      ->get();
      $studentsArray = [];

      foreach($students as $key => $stud){
        $student = Student::find($stud->id);
        $events = Student::find($stud->id)->event()->whereIn('event_type_id', [4])->get()->toArray();
        $letters = $student->letters->toArray();
        $studentArray = $student->toArray();
        $studentArray['count'] = "*" . count($events) . "*";
        $studentArray['event'] = $events;
        $studentArray['letter_count'] = "-" . count($letters) . "-";
        $studentArray['grade'] = "~" . $studentArray['grade'] . "~";
        $studentArray['edit'] = "Edit";
        $studentsArray[] = $studentArray;
      }
      return response()->json($studentsArray);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTardies()
    {
      $students = DB::table('students')
                      ->selectRaw('DISTINCT students.id')
                      ->join('events', 'students.id', '=', 'events.student_id')
                      ->whereIn('events.event_type_id', [2])
                      ->get();
      $studentsArray = [];

      foreach($students as $key => $stud){
        $student = Student::find($stud->id);
        $events = Student::find($stud->id)->event()->whereIn('event_type_id', [2])->get()->toArray();
        $letters = $student->letters->toArray();
        $studentArray = $student->toArray();
        $studentArray['count'] = "*" . count($events) . "*";
        $studentArray['event'] = $events;
        $studentArray['letter_count'] = "-" . count($letters) . "-";
        $studentArray['grade'] = "~" . $studentArray['grade'] . "~";
        $studentArray['edit'] = "Edit";
        $studentsArray[] = $studentArray;
      }
      return response()->json($studentsArray);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEDs()
    {
      $students = DB::table('students')
                      ->selectRaw('DISTINCT students.id')
                      ->join('events', 'students.id', '=', 'events.student_id')
                      ->whereIn('events.event_type_id', [3])
                      ->get();
      $studentsArray = [];

      foreach($students as $key => $stud){
        $student = Student::find($stud->id);
        $events = Student::find($stud->id)->event()->whereIn('event_type_id', [3])->get()->toArray();
        $letters = $student->letters->toArray();
        $studentArray = $student->toArray();
        $studentArray['count'] = "*" . count($events) . "*";
        $studentArray['event'] = $events;
        $studentArray['letter_count'] = "-" . count($letters) . "-";
        $studentArray['grade'] = "~" . $studentArray['grade'] . "~";
        $studentArray['edit'] = "Edit";
        $studentsArray[] = $studentArray;
      }
      return response()->json($studentsArray);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent(Request $request)
    {

        $eventId = request()->input('event');
        $event =  Event::find($eventId);
        $event->delete();
        return 'success';

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteLetter(Request $request)
    {
        $letterId = request()->input('letter');
        $studentId = request()->input('studentId');
        $student =  Student::find($studentId);
        $letter = Letter::find($letterId);
        $student->letters()->detach($letter);
        $student->save();
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student =  Student::find($id);
        $events = $student->event->toArray();
        $letters = $student->letters->toArray();
        $studentArray = $student->toArray();
        $studentArray['event'] = $events;
        $studentArray['letters'] = $letters;

        return response()->json($studentArray);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = request()->input('params');
        $student =  Student::find($id);
        $student->grade = $params['grade'];
        $student->language = $params['language'];
        $student->save();

        return 'Updates saved';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
