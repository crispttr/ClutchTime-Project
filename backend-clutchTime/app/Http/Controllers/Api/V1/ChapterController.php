<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;

class ChapterController extends Controller
{
    public function index()
    {
        return response()->json(
            Chapter::with(['story', 'choices'])->get(),
            200
        );
    }

    public function store(StoreChapterRequest $request)
    {
        $chapter = Chapter::create($request->validated());
        return response()->json($chapter, 201);
    }

    public function show(Chapter $chapter)
    {
        $chapter->load(['story', 'choices']);
        return response()->json($chapter, 200);
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        $chapter->update($request->validated());
        return response()->json($chapter, 200);
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return response()->json(['message' => 'Chapitre supprimé'], 200);
    }
}
