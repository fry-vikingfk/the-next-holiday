<?php

namespace App\Http\Controllers;

use App\Http\Requests\State\StoreStateRequest;
use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Resources\State\StateResource;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', State::class);

        return response()->json([
            'message' => 'List of states',
            'data' => StateResource::collection(State::with(['holidays', 'country'])->paginate(10)),
        ])->setStatusCode(200);
    }

    public function store(StoreStateRequest $request)
    {
        $this->authorize('create', State::class);

        $state = State::create($request->validated());

        return response()->json([
            'message' => 'State created successfully',
            'data' => StateResource::make($state),
        ])->setStatusCode(201);
    }

    public function show(State $state)
    {
        $this->authorize('view', $state);

        $state->load('holidays');

        return response()->json([
            'message' => 'State details',
            'data' => StateResource::make($state),
        ])->setStatusCode(200);
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        $this->authorize('update', $state);

        $state->update($request->validated());

        return response()->json([
            'message' => 'State updated successfully',
            'data' => StateResource::make($state),
        ])->setStatusCode(202);
    }

    public function destroy(State $state)
    {
        $this->authorize('delete', $state);

        $state->delete();

        return response()->noContent();
    }
}
