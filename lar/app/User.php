<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Mail\UserConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    const NEWS_EDITOR = 5;
    const USER = 1;

    /**
     * создание пользователя и отправка письма для подтверждения
     */
    public static function createUser()
    {
        $skey = base64_encode(request('email') . date('d.m.Y'));
        $key = md5(request('email') . date('d.m.Y'));
        $newUser = new self;
        $newUser->name = request('name');
        $newUser->email = request('email');
        $newUser->password = password_hash(request('password'), PASSWORD_DEFAULT);;
        $newUser->username = request('username');
        $newUser->server_key = $skey;
        try {
            if ($newUser->save()) {
                Mail::to(request('email'))
                    ->queue(new UserConfirmation($key, base64_encode($newUser->email)));
                return true;
            }
        } catch(\Exception $exc) {
            throw $exc;
        }
        return false;
    }

    /**
     * редактирование профиля пользователя
     */
    public static function updateUser()
    {
        try {
            $skey = request('server_key');
            $user = self::where('server_key', '=', $skey)->firstOrFail();
            $user->name = request('name');
            $user->username = request('username');
            $user->email = request('email');
            $pass = request('password', null);
            if (!empty($pass) && !password_verify($pass, $user->password)) {
                $user->password = password_hash($pass, PASSWORD_DEFAULT);
            }
            $user->save();
            return true;
        } catch (ModelNotFoundException $ex) {
            throw new \Exception('Пользователь не найден');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    /**
     * активация пользователя по email
     */
    public static function setActiveByEmail($email)
    {
        try {
            $user = self::where('email', '=', $email)->firstOrFail();
            if ($user->active == self::STATUS_INACTIVE) {
                $user->active = self::STATUS_ACTIVE;
                $user->save();
            }
            return $user->server_key;
        } catch(\Exception $exc) {
            throw $exc;
        }
        return '';
    }

    /**
     * возвращает пользователя по username и password
     */
    public static function getUserByLogoPas($username, $pass)
    {
        try {
            $user = self::where('username', '=', $username)->first();
            if (!empty($user) && password_verify($pass, $user->password)) {
                return $user;
            } else {
                return null;
            }
        } catch(\Exception $exc) {
            throw $exc;
        }
    }
}
