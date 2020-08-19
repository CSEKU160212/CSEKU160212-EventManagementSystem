<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Auth\Events\Validated;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all()->sortBy('event_start_date', 'desc');
        return response()->json(['event'=> $events, 'message' => 'Successfully Retrieved All Event'], 200);
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
       $request->validate([
            'title' => 'required|string',
            'organized_by' =>'required|string',
            'venue' => 'required|string',
            'event_start_date' => 'required|date',
            'event_length' => 'required|string',
            'reg_start_date' => 'required|date',
            'reg_end_date' => 'required|date',
            'decription' => 'require|string',
            'contact_no' => 'require|string',
            'contact_email' => 'require|string|email',
       ]);

        $event = new Event([
            'title' => $request->title,
            'organized_by' =>$request->organized_by,
            'venue' => $request->venue,
            'event_start_date' => $request->event_start_date,
            'event_length' => $request->event_length,
            'reg_start_date' => $request->reg_start_date,
            'reg_end_date' => $request->reg_end_date,
            'decription' => $request->decription,
            'contact_no' => $request->contact_no,
            'contact_email' => $request->contact_email,
        ]);

       if($event->save()){
            return response()->json(['message' => 'Event created succesfully', 'event' => $event], 200 );
       }else{
            return response()->json(['message' => 'Failed to create event'], 400);
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $event = Event::find($id);
        if($event){
            return response()->json(['message' => 'Successfully found event', 'event' => $event], 200);
        }else{
            return response()->json(['message' => 'Failed to find event'], 400);
        }
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
