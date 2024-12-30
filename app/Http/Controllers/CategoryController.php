<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Brend;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::get();
    }
    public function store(CategoryRequest $request)
    {
        try {
            Category::create([
                'category_title' => $request->category_title,
                'raise' => $request->category_raise,
            ]);
            return response()->json(['message' => 'Amaliyot bajarildi'], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Dasturda kutilmagan xatolik',
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ], 500);
        }
    }
    public function get_all()
    {
        return Brend::where('active', true)->get();
    }
}
