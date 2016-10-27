<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Orm\Model;

class Comment
    extends Model
{
    static protected $schema = [
        'columns' => [
            'body' => ['type' => 'text'],
            'published' => ['type' => 'datetime'],
        ],
        
        'relations' => [
            'post' => ['type' => self::BELONGS_TO, 'model' => Post::class],
            'author' => ['type' => self::BELONGS_TO, 'model' => User::class],
        ],
    ];

    protected function validateBody($val)
    {
        if ('' == $val) {
            throw new Exception('Комментарий не может быть пустым');
        }
        return true;
    }
}