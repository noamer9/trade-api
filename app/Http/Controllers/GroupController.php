<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Resources\Group as groupResource;
use App\Http\Controllers\APIBaseController as APIBaseController;
use Validator;

class GroupController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Group::all();
        // $collection = collect([
        //     ['name' => 'Desk', 'price' => 200],
        //     ['name' => 'Chair', 'price' => 100],
        //     ['name' => 'Bookcase', 'price' => 150],
        // ]);

        $sorted = $games->sortBy('date_of_match');

        $sorted->values()->all();
        return $this->sendResponse(groupResource::collection($sorted), 'games retrieved successfully.');
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


        $validator = Validator::make($input, [

            'user_id' => 'required',
            'city_id' => 'required',
            'team_a' => 'required',
            'team_b' => 'required',
            'date_of_match' => 'required',
        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());

        }


        $groups = Group::create($input);

        return $this->sendResponse( new groupResource($groups), 'groups created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Group::find($id);

        if (!is_null($game)) {

            try {
                $game->delete();
                return $this->sendResponse($id, 'game a deleted successfully.');
            } catch (\Exception $e){
                return $this->sendError($e, 'game cannot be deleted drop constarins first.');
            }

        }
    }
}
