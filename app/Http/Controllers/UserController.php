<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public  function register(UserRegisterRequest $request){
        $user = User ::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'password' => Hash::make($request->password)
           ]);
           $token = $user->createToken('auth-sanctum')->plainTextToken;
           return response()->json([
            'message' => 'Siz muvaffaqiyatli ro\'yhatdan o\'tdingiz!',
            'token' => $token
        ],201);
    }
    public function login(UserRequest $request){
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
        return 'error';

    $user = User::where('username', $request->get('username'))->first();
    if (!$user)
        return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
    if (!Hash::check($request->get('password'), $user->password))
        return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

    $token = $user->createToken('auth-token')->plainTextToken;
    return response()->json(["token" => $token],200);
    }
    public function update(UserUpdateRequest $request, $id){
        if (!($this->check('user', 'update'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        if(auth()->id() != $id){
            return response()->json(['message'=>"Boshqa foydalanuvchi ma'lumotini  o'zgartirish uchun huquq yo'q!"],403);
        }
       User::where('id',$id)->first()
       ->update([
            'full_name' => $request->full_name,
            'password' => Hash::make($request->password)
       ]);
       return response()->json(['message' => 'Amaliyot bajarildi'],200);
    }
    public function get_profil(){
        return auth()->user();
    }
}
