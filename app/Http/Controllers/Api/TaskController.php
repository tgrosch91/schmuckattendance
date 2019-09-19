<?php

namespace App\Http\Controllers\Api;

use App\Student;
use App\Letter;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

  /**
    * Create a new controller instance.
    *
    * @param  EventService  $eventService
    * @return void
    */
    public function __construct(EventService $eventService)
    {
      $this->eventService = $eventService;
    }
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
    public function complete(Request $request)
    {
        $letterId = request()->input('letter');
        $studentsToUpdate = request()->input('students');
        $letter =  Letter::find($letterId);
        foreach($studentsToUpdate as $studentId){
          $student = Student::find($studentId);
          $student->letters()->attach($letter);
          $student->save();
        }
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
        switch($id){
          case 8:
          case 9:
            $students = $this->eventService->getStudentsConsecutiveDays($id);
          break;
          default:
            $students = $this->eventService->getStudentsNeeding($id);
          break;
        }
        return response()->json($students);
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
        //
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
