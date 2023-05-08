<?php

namespace App\Http\Controllers\Generics;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
//        return response()->json(State::all());
         return response()->json(['data' => State::all()]);
    }
}
