<?php

namespace App\Http\Controllers;

use App\Symbole;
use Illuminate\Http\Request;
use App\Http\Resources\Symbole as newSymbole;
use App\Http\Controllers\APIBaseController as APIBaseController;
use Validator;

class SymboleController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $symboles = Symbole::all();
        return $this->
        sendResponse(newSymbole::collection($symboles),
         'symboles retrieved successfully.');
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

        if(isset($input['symbol'])) {
            $rules['symbol'] = 'required|min:1';
        }

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return $this->
            sendError('Validation Error.', $validator->errors());
        }
        try {
            $NewSymbole = Symbole::create($input);
            $NewSymbole->save();

        } catch (\Exception $e) {
            return $this->sendError('value exist');
        }


        if($NewSymbole->save()){
            return $this->sendResponse(new newSymbole($NewSymbole),
             'newSymbole created successfully.');
        }
        return $this->sendError($e, 'value exists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Symbole  $symbole
     * @return \Illuminate\Http\Response
     */
    public function show(Symbole $symbole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Symbole  $symbole
     * @return \Illuminate\Http\Response
     */
    public function edit(Symbole $symbole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Symbole  $symbole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Symbole $symbole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Symbole  $symbole
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $symbole = Symbole::find($id);
        if (!is_null($symbole)) {
            try {
                $symbole->delete();
                return $this->
                sendResponse($id, 'symbole  deleted successfully.');
            } catch (\Exception $e){
                return $this->
                sendError($e,
                 'symbole cannot be deleted drop constarins first.');
            }

        }
    }
}
