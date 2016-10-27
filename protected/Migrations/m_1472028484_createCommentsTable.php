<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1472028484_createCommentsTable
    extends Migration
{

    public function up()
    {
        $this->createTable('comments', [
            'body' => ['type' => 'text'],
            'published' => ['type' => 'datetime'],
            '__post_id' => ['type' => 'link'],
            '__user_id' => ['type' => 'link'],
        ]);
    }

    public function down()
    {
        $this->dropTable('comments');
    }
    
}