<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrendRequest;
use App\Http\Resources\BrendResource;
use App\Models\Brend;
use Illuminate\Http\Request;

class BrendController extends Controller
{
    public function index()
    {
        $parPage = request('par_page',15);
        $search = request('search');
        $data =  Brend:: when($search,function($query)use($search){
            $query->where('brend_title',"LIKE","%$search%");
        })
        ->paginate($parPage);
        return BrendResource::collection($data);
    }
    public function store(BrendRequest $request)
    {
        try {
            Brend::create([
                'brend_title' => $request->brend_title
            ]);
            return response()->json(['message' => "Ma'lumot muvaffaqiyatli qo'shildi"], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lumot qo'shishda xatolik yuzga keldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function get_all()
    {
        return Brend::where('active', true)->get();
    }
}