<?php

namespace App\Http\Controllers\Generics;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
//        return response()->json(Category::all());
         return response()->json(['data' => Category::all()]);
    }
}
