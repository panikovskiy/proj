<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    /**
     * регистрация пользователя
     */
    public function registration()
    {
        $this->validate(request(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        try {
            if (User::createUser()) {
                return response()->json(['message' => 'ok'], 200);
            }
        } catch(\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }

    /**
     * подтверждение почты
     */
    public function check()
    {
        $this->validate(request(), [
            'email' => 'required',
            'key' => 'required'
        ]);
        $email = base64_decode(request('email'));
        $key = md5($email . date('d.m.Y'));
        if ($key === request('key')) {
            try {
                if ($server_key = User::setActiveByEmail($email)) {
                    return response()->json([
                        'message' => 'Пользователь удачно зарегистрирован',
                        'server_key' => $server_key
                    ], 200);
                }
            } catch(\Exception $exc) {
                return response()->json(['error' => $exc->getMessage()], 500);
            }
        } else {
            return response()->json(['error' => 'Неверный ключ для активации пользователя'], 406);
        }
    }

    /**
     * авторизация пользователя
     */
    public function auth() 
    {
        $this->validate(request(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        try {
            $user = User::getUserByLogoPas(request('username'), request('password'));
            if (empty($user)) {
                return response()->json(['error' => 'Пользователь не найден'], 404);
            }
            if ($user->active == User::STATUS_INACTIVE) {
                return response()->json(['error' => 'Пользователь не активирован'], 406);
            }
            return response()->json(['server_key' => $user->server_key], 200);
        } catch(\Exception $exc) {
            return response()->json(['error' => $exc->getMessage()], 500);
        }
    }
}
