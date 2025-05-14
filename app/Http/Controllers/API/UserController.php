<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function show()
    {
        return response()->json([
            'user' => auth()->user()
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        auth()->user()->update($request->validated());
        return response()->json(['message' => 'Profile updated']);
    }
}