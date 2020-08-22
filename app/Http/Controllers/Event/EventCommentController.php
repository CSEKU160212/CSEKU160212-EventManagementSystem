<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EventComment;
use Illuminate\Support\Carbon;

class EventCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($eventid)
    {
        $eventComments = EventComment::all()->where('eventid', $eventid);
        if(!$eventComments){
            return response()->json(['message' => 'No comment found'], 400);
        }else{
            return response()->json(['message' => 'Comments found successfully', 'eventComments' => $eventComments], 200);
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
        $userid = auth('api')->user()->id;

        $eventComment = EventComment::create([
            'comment' => $request->comment,
            'eventid' => $eventid,
            'userid' => $userid
        ]);

        if($eventComment->save()){
            return response()->json(['message' => 'Commented Successfully', 'eventComment' => $eventComment], 201);
        }else{
            return response()->json(['message' => 'Failed to create option'], 400);
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $commentid
     * @return \Illuminate\Http\Response
     */
    public function show($commentid)
    {
        $eventComment = EventComment::find($commentid);
        if($eventComment){
            return response()->json(['message' => 'Found event comment successfully', 'eventComment' => $eventComment], 200);
        }else{
            return response()->json(['message' => 'Failed to find event comment'], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($commentid)
    {
        $eventComment = EventComment::find($commentid);

        if($eventComment && $eventComment->user->id == auth('api')->user()->id){
            return response()->json(['message' => 'Event option retrieved successfully', 'eventComment'=>$eventComment], 200);
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
    public function update(Request $request, $commentid)
    {
        $comment = EventComment::find($commentid);

        if(!$comment || $comment->user->id != auth('api')->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }elseif($comment->update($request->all())){
            return response()->json(['mesage' => 'Comment updated successfully', 'eventComment'=>$comment], 200);
        }else{
            return response()->json(['mesage' => 'Comment update unsuccessfull', 'eventComment'=>$comment], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($commentid)
    {
        $comment = EventComment::find($commentid);
        if(!$comment || $comment->user->id != auth('api')->user()->id){
            return response()->json(['message' => 'Forbidden'], 403);
        }elseif($comment->delete()){
            return response()->json(['mesage' => 'Comment deleted successfully'], 200);
        }else{
            return response()->json(['mesage' => 'Couldn\'t delete comment', 'eventComment'=>$comment], 400);
        }
    }
}
