<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Resources\Event as newEvent;
use App\Http\Controllers\APIBaseController as APIBaseController;
use Validator;
class EventController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return $this->
        sendResponse(newEvent::collection($events),
         'events retrieved successfully.');
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
        $input = $request->all();
        $rules = array();

        if(isset($input['title'])) {
            $rules['title'] = 'required|min:3';
        }

        if(isset($input['content'])) {
            $rules['content'] = 'required|min:8';
        }

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->
            sendError('Validation Error.', $validator->errors());
        }
        try {
            $NewEvent = Event::create($input);
            $NewEvent->save();

        } catch (\Exception $e) {
            return $this->sendError('value exist');
        }


        if($NewEvent->save()){
            return $this->sendResponse(new newEvent($NewEvent),
             'newEvent created successfully.');
        }
        return $this->sendError($e, 'value exists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $rules = array();

        if(isset($input['title'])) {
            $rules['title'] = 'required|min:3';
        }

        if(isset($input['content'])) {
            $rules['content'] = 'required|min:8';

        }
        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->
            sendError('Validation Error.', $validator->errors());
        }

        $event = Event::find($id);
        if (is_null($event)) {
            return $this->sendError('event not found.');
        }

        try {
            $event->update($input);
            $event->save();
            return $this->sendResponse(new newEvent($event),
             'event updated successfully.');

        } catch (\Exception $e) {
            return $this->sendError('value exist');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!is_null($event)) {
            try {
                $event->delete();
                return $this->
                sendResponse($id, 'event  deleted successfully.');
            } catch (\Exception $e){
                return $this->
                sendError($e,
                 'event cannot be deleted drop constarins first.');
            }

        }
    }
}
