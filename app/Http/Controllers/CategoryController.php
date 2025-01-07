<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\UniversalResource;
use App\Models\Brend;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (!($this->check('category', 'get'))) return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        $parPage = request('par_page', 15);
        $search = request('search');
        $data =  Category::when($search, function ($query) use ($search) {
            $query->where('category_title', "LIKE", "%$search%");
        })
            ->paginate($parPage);
        return CategoryResource::collection($data);
    }
    public function store(CategoryRequest $request)
    {
        if (!($this->check('category', 'add'))) return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        try {
            Category::create([
                'category_title' => $request->category_title,
                'raise' => $request->raise,
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
        if (!($this->check('category', 'show'))) return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        return Category::where('active', true)->get();
    }
}
