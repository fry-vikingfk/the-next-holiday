<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // fetch all states from the database
        return response()->json([
            'message' => 'List of states',
            'data' => StateResource::collection(State::all())
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        $state = State::create($request->validated());

        return response()->json([
            'message' => 'State created successfully',
            'data' => StateResource::make($state)
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, string $id)
    {
        $state = State::findOrFail($id);
        $state->update($request->validated());

        return response()->json([
            'message' => 'State updated successfully',
            'data' => StateResource::make($state)
        ])->setStatusCode(202);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
