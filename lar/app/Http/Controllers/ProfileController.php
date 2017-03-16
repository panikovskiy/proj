<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function getPofile()
    {
        $key = request('server_key');
        if (empty($key)) {
            return response()->json(['error' => 'Необходима авторизация'], 401);
        } else {
            $user = User::where('server_key', '=', $key)->first();
            if (empty($user)) {
                return response()->json(['error' => 'Пользователь не найден'], 404);
            }
            if ($user->active == User::STATUS_INACTIVE) {
                return response()->json(['error' => 'Пользователь не активирован'], 406);
            }
            return response()->json([
                'name'  => $user->name,
                'username' => $user->username,
                'email' => $user->email
            ], 200);
        }
    }

    public function savePofile() {
        $this->validate(request(), [
            'server_key' => 'required',
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required_with:password_confirmation|confirmed',
            'password_confirmation' => 'required_with:password'
        ]);
        try {
            User::updateUser();
            return response()->json(['message' => 'Профиль изменен'], 200);
        } catch (\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }
}