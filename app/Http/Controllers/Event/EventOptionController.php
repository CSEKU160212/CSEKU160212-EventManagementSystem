<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventOption;

class EventOptionController extends Controller
{

    // ***successfully tested: index, store, edit, show, update, destroy methods

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventid)
    {
        $eventOptions = EventOption::all()->where('eventid', $eventid);
        if($eventOptions){
            return response()->json(['message' => 'Successfully Retrieved event option', 'eventOptions' => $eventOptions], 200);
        }
        else{
            return response()->json(['message' => 'Couldn\'t find any option'], 204);
        }
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
    public function store(Request $request, $eventid)
    {
        $eventOptions = EventOption::create([
            'title' => $request->title,
            'time' => $request->time,
            'place' => $request->place,
            'eventid' => $eventid,
            'fee' => $request->fee
        ]);

        if($eventOptions->save()){
            return response()->json(['message' => 'Options created Successfully', 'eventOptions' => $eventOptions], 201);
        }else{
            return response()->json(['message' => 'Failed to create option'], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($optionid)
    {
        $eventOption = EventOption::find($optionid);
        if($eventOption){
            return response()->json(['message' => 'Found event option successfully', 'eventOption' => $eventOption], 200);
        }else{
            return response()->json(['message' => 'Failed to find event option'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($optionid)
    {
        $eventOption = EventOption::find($optionid);
        if($eventOption && $eventOption->event->userid == auth('api')->user()->id){
            return response()->json(['message' => 'Event option retrieved successfully', 'eventOption'=>$eventOption], 200);
        }else{
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $optionid)
    {
        $option = EventOption::find($optionid);

        if(!$option || $option->event->userid != auth('api')->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }elseif($option->update($request->all())){
            return response()->json(['mesage' => 'Option updated successfully', 'eventOption'=>$option], 200);
        }else{
            return response()->json(['mesage' => 'Option update unsuccessfull', 'eventOption'=>$option], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($optionid)
    {
        $option = EventOption::find($optionid);
        if(!$option || $option->event->userid != auth('api')->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }elseif($option->delete()){
            return response()->json(['mesage' => 'Option deleted successfully'], 200);
        }else{
            return response()->json(['mesage' => 'Couldn\'t delete option', 'eventOption'=>$option], 400);
        }
    }
}
