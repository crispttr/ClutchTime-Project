<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;

class StoryController extends Controller
{
    public function index()
    {
        return response()->json(Story::all(), 200);
    }

    public function store(StoreStoryRequest $request)
    {
        $story = Story::create($request->validated());
        return response()->json($story, 201);
    }

    public function show(Story $story)
    {
        return response()->json($story, 200);
    }

    public function update(UpdateStoryRequest $request, Story $story)
    {
        $story->update($request->validated());
        return response()->json($story, 200);
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return response()->json(['message' => 'Histoire supprimée'], 200);
    }
}
