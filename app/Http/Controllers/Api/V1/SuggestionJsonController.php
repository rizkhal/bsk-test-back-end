<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Http\Resources\SuggestionResource;

class SuggestionJsonController extends Controller
{
    public function index(Request $request)
    {
        return SuggestionResource::collection(
            Suggestion::query()->paginate(10)
        );
    }

    public function store(SuggestionRequest $request)
    {
        return SuggestionResource::make(
            Suggestion::create($request->validated())
        );
    }

    public function update(Suggestion $suggestion, SuggestionRequest $request)
    {
        $suggestion->update($request->validated());
        
        return SuggestionResource::make($suggestion);
    }

    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();

        return response()->json([
            'message' => __('Successfully delete suggestion'),
        ]);
    }
}
