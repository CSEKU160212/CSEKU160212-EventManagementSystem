<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Validation\Validator;

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
        $request->userid = auth('api')->user()->id;
        $event = new Event([
            'title' => $request->title,
            'organized_by' =>$request->organized_by,
            'venue' => $request->venue,
            'event_start_date' => $request->event_start_date,
            'event_length' => $request->event_length,
            'reg_start_date' => $request->reg_start_date,
            'reg_end_date' => $request->reg_end_date,
            'description' => $request->description,
            'contact_no' => $request->contact_no,
            'contact_email' => $request->contact_email,
            'userid' => $request->userid,
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
    public function show($id)
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
     * @param  object $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return response()->json(['event'=>$event], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        if($event->update($request->all())){
            return response()->json(['mesage', 'Event updated successfully', 'event'=>$event], 200);
        }else{
            return response()->json(['mesage', 'Event update unsuccessfull', 'event'=>$event], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->delete()){
            return response()->json(['message' => 'Event deleted succesfully'], 200);
        }else{
            return response()->json(['message' => 'Can\'t delete event'], 400);
        }
    }

    /* public function validateData(Request $request){
        
         $request->validate([
             'title' => 'required|string',
             'organized_by' => 'required|string',
             'venue' => 'required|string',
             'event_start_date' => 'required|date',
             'event_length' => 'required|string',
             'reg_start_date' => 'required|date',
             'reg_end_date' => 'required|after_or_equal:reg_start_date',
             'description' => 'require|string',
             'contact_no' => 'string',
             'contact_email' => 'string|email',
        ]);
     }
     */

}
