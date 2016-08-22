<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1471514972_createPostsTable
    extends Migration
{
    public function up()
    {
        $this->createTable('posts', [
            'title' => ['type' => 'string'],
            'content' => ['type' => 'text'],
            'published' => ['type' => 'datetime'],
            '__user_id' => ['type' => 'link'],
        ]);
    }

    public function down()
    {
        $this->dropTable('posts');
    }
}