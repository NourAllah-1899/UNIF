<?php

namespace App\Http\Controllers\API;

use App\Models\Card;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardRequest;

class CardController extends Controller
{
    public function index()
    {
        return response()->json([
            'cards' => auth()->user()->cards
        ]);
    }

    public function store(StoreCardRequest $request)
    {
        $card = auth()->user()->cards()->create($request->validated());
        return response()->json($card, 201);
    }
}