<?php

namespace App\Http\Controllers\Api;

use App\Import;
use App\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Vendor\PhpOffice\PhpSpreadsheet;

class ImportController extends Controller
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
      $imports = Import::all();
      return response()->json($imports);
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
       // Validate the request...
       $file = request()->file('file');
       $date = request()->input('date');
       $eventType = request()->input('type');
       $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       $spreadsheet = $reader->load($file->path());
       $worksheet = $spreadsheet->getActiveSheet();
       $import = new Import;
       $currentTime = (!$date || $date === '') ? Carbon::now()->toDateString() : $date;
       $import->date = $currentTime;
       $import->file_name = $file->getClientOriginalName();
       $import->save();
       $importId = $import->id;
       foreach ($worksheet->getRowIterator() as $row) {
          $rowValues = [$importId,$currentTime];
          $cellIterator = $row->getCellIterator();
          $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells
          foreach ($cellIterator as $cell) {
                   $value = $cell->getValue();
                   $rowValues[] = $value;
          }
          $this->eventService->make($rowValues, $eventType);
        }
        return 'Import successful';
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $import = Import::findOrFail($id);
        $import->delete();
    }
}
