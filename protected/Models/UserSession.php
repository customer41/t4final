<?php

namespace App\Models;

use T4\Orm\Model;

class UserSession
    extends Model
{
    static protected $schema = [
        'table' => '__user_sessions',

        'columns' => [
            'hash' => ['type' => 'string'],
        ],

        'relations' => [
            'user' => ['type' => self::BELONGS_TO, 'model' => User::class],
        ],
    ];
}