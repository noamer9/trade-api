<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as user;
use App\Http\Controllers\APIBaseController as APIBaseController;
use App\NewUser;
use Validator;
class UserController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = NewUser::all();
        return $this->sendResponse(user::collection($users), 'users retrieved successfully.');
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

        if(isset($input['name'])) {
            $rules['name'] = 'required|min:2';
        }

        if(isset($input['phone'])) {
            $rules['phone'] = 'required|min:8|max:11';

        }


        $validator = Validator::make($input, $rules);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());

        }
        try {
            $NewUser = NewUser::create($input);
            $NewUser->save();

        } catch (\Exception $e) {
            return $this->sendError('value exist');
        }


        if($NewUser->save()){
            return $this->sendResponse(new user($NewUser), 'User created successfully.');
        }
        return $this->sendError($e, 'value exists');

        return $this->sendResponse( new user($NewUser), 'User created successfully.');
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
        $input = $request->all();
        $rules = array();

        if(isset($input['name'])) {
            $rules['name'] = 'required|min:2';
        }

        if(isset($input['phone'])) {
            $rules['phone'] = 'required|min:8|max:11';

        }
        $validator = Validator::make($input, $rules);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());

        }


        $user = NewUser::find($id);

        if (is_null($user)) {

            return $this->sendError('user not found.');

        }

        try {
            $user->update($input);
            // $user->save();
            return $this->sendResponse(new user($user), 'user updated successfully.');

        } catch (\Exception $e) {
            return $this->sendError('value exist');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $userInfo = User::find($id)->info;
        // $userComments = User::find($id)->comments;
        $user = NewUser::find($id);

        if (!is_null($user)) {

            try {
                $user->delete();
                return $this->sendResponse($id, 'user and user info deleted successfully.');
            } catch (\Exception $e){
                return $this->sendError($e, 'user cannot be deleted drop constarins first.');
            }

        }

    }
}
