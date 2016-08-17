<?php

namespace App\Components\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\UserSession;
use T4\Http\Helpers;

class Identity
{
    public function login($data)
    {
        $errors = new MultiException();

        if (empty($data->email)) {
            $errors->add( new Exception('Пустой email') );
        }
        if (empty($data->password)) {
            $errors->add( new Exception('Пустой пароль') );
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        $user = User::findByEmail($data->email);
        if (empty($user)) {
            $errors->add( new Exception('Пользователя с таким email не существует') );
            throw $errors;
        }

        if (!password_verify($data->password, $user->password)) {
            $errors->add( new Exception('Неверный пароль') );
            throw $errors;
        }

        $hash = sha1(microtime() . mt_rand());
        $session = new UserSession();
        $session->hash = $hash;
        $session->user = $user;
        $session->save();

        if (isset($data->remember) && 'on' == $data->remember) {
            Helpers::setCookie('t4auth', $hash, time() + 30*24*60*60);
        } else {
            Helpers::setCookie('t4auth', $hash);
        }
    }

    public function logout()
    {
        if (Helpers::issetCookie('t4auth')) {
            if (!empty($hash = Helpers::getCookie('t4auth'))) {
                Helpers::unsetCookie('t4auth');
                $session = UserSession::findByHash($hash);
                if (!empty($session)) {
                    $session->delete();
                }
            }
        }
    }

    public function getUser()
    {
        if (Helpers::issetCookie('t4auth')) {
            if (!empty($hash = Helpers::getCookie('t4auth'))) {
                if (!empty($session = UserSession::findByHash($hash))) {
                    return $session->user;
                }
            }
        }
        return null;
    }

    public function register($data)
    {
        $errors = new MultiException();

        if (empty($data->firstname)) {
            $errors->add( new Exception('Не введено имя') );
        }
        if (empty($data->lastname)) {
            $errors->add( new Exception('Не введена фамилия') );
        }
        if (empty($data->email)) {
            $errors->add( new Exception('Не введён email') );
        } elseif (!empty(User::findByEmail($data->email))) {
            $errors->add( new Exception('Пользователь с таким email уже зарегистрирован') );
        }
        if (empty($data->password) || empty($data->repassword)) {
            $errors->add( new Exception('Не введён пароль') );
        } elseif ($data->password !== $data->repassword) {
            $errors->add( new Exception('Введённые пароли не совпадают') );
        }

        if (!$errors->isEmpty()) {
            throw $errors;
        }

        try {
            $user = new User();
            $user->fill([
                'email' => $data->email,
                'password' => $data->password,
                'firstName' => $data->firstname,
                'lastName' => $data->lastname,
            ]);
        } catch (\T4\Core\MultiException $e) {
            foreach ($e as $error) {
                $errors->add($error);
            }
            throw $errors;
        }
        $user->registered = date('Y-m-d H:i:s');
        $user->roles->add(Role::findByName('User'));
        $user->save();
        return $user;
    }
}