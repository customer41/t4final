<?php

namespace App\Models;

use T4\Orm\Model;

class Post
    extends Model
{
    static protected $schema = [
        'columns' => [
            'title' => ['type' => 'string'],
            'content' => ['type' => 'text'],
            'published' => ['type' => 'datetime'],
        ],

        'relations' => [
            'author' => ['type' => self::BELONGS_TO, 'model' => User::class],
            'comments' => ['type' => self::HAS_MANY, 'model' => Comment::class],
        ],
    ];
}