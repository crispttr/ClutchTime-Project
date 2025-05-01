<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Http\Requests\StoreChoiceRequest;
use App\Http\Requests\UpdateChoiceRequest;

class ChoiceController extends Controller
{
    public function index()
    {
        return response()->json(
            Choice::with(['chapter', 'nextChapter'])->get(),
            200
        );
    }

    public function store(StoreChoiceRequest $request)
    {
        $choice = Choice::create($request->validated());
        return response()->json($choice, 201);
    }

    public function show(Choice $choice)
    {
        $choice->load(['chapter', 'nextChapter']);
        return response()->json($choice, 200);
    }

    public function update(UpdateChoiceRequest $request, Choice $choice)
    {
        $choice->update($request->validated());
        return response()->json($choice, 200);
    }

    public function destroy(Choice $choice)
    {
        $choice->delete();
        return response()->json(['message' => 'Choix supprimé'], 200);
    }
}
