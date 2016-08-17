<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Orm\Model;

class User
    extends Model
{
    static protected $schema = [
        'table' => '__users',
        
        'columns' => [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'registered' => ['type' => 'datetime'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName' => ['type' => 'string', 'length' => 50],
        ],

        'relations' => [
            'roles' => ['type' => self::MANY_TO_MANY, 'model' => Role::class, 'on' => '__user_roles_to_users'],
        ],
    ];

    protected function validatePassword($val)
    {
        if (60 == strlen($val)) {
            return true;
        }
        if (!preg_match('~^[a-zA-Z0-9]{6,15}$~', $val)) {
            throw new Exception('Пароль может состоять только из цифр и латинских букв. Длина от 6 до 15 символов.');
        }
        return true;
    }
    
    protected function validateFirstName($val)
    {
        if (!preg_match('~^[a-zA-Zа-яA-ЯёЁ]{2,15}$~u', $val)) {
            throw new Exception('В имени могут быть только буквы. Длина от 2 до 15 символов.');
        }
        return true;
    }

    protected function validateLastName($val)
    {
        if (!preg_match('~^[a-zA-Zа-яA-ЯёЁ]{2,15}$~u', $val)) {
            throw new Exception('В фамилии могут быть только буквы. Длина от 2 до 15 символов.');
        }
        return true;
    }

    protected function sanitizePassword($val)
    {
        if (60 == strlen($val)) {
            return $val;
        }
        return password_hash($val, PASSWORD_DEFAULT);
    }
    
    protected function sanitizeFirstName($val)
    {
        return mb_convert_case($val, MB_CASE_TITLE);
    }

    protected function sanitizeLastName($val)
    {
        return mb_convert_case($val, MB_CASE_TITLE);
    }
}