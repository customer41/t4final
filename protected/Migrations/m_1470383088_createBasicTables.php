<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1470383088_createBasicTables
    extends Migration
{
    public function up()
    {
        $this->createTable('__users', [
            'email' => ['type' => 'string'],
            'password' => ['type' => 'string'],
            'registered' => ['type' => 'datetime'],
            'firstName' => ['type' => 'string', 'length' => 50],
            'lastName' => ['type' => 'string', 'length' => 50],
        ], [
            'email_idx' => ['type' => 'unique', 'columns' => ['email']],
        ]);

        $adminId = $this->insert('__users', [
            'email' => 'alien1986cs@gmail.com',
            'password' => '$2y$10$6.HRJjNGlYFI9hW1HQouyeJXum8792X.f8C502on4jjO1r0qSi/a.',
            'registered' => date('Y-m-d H:i:s'),
            'firstName' => 'Александр',
            'lastName' => 'Попов',
        ]);

        $this->createTable('__user_roles', [
            'name' => ['type' => 'string'],
            'title' => ['type' => 'string'],
        ], [
            ['type' => 'unique', 'columns' => ['name']],
        ]);

        $adminRoleId = $this->insert('__user_roles', [
            'name' => 'Admin',
            'title' => 'Администратор',
        ]);

        $this->createTable('__user_roles_to_users', [
            '__user_id' => ['type' => 'link'],
            '__role_id' => ['type' => 'link'],
        ]);

        $this->insert('__user_roles_to_users', [
            '__user_id' => $adminId,
            '__role_id' => $adminRoleId,
        ]);

        $this->createTable('__user_sessions', [
            'hash' => ['type' => 'string'],
            '__user_id' => ['type' => 'link'],
        ], [
            'hash' => ['columns' => ['hash']],
            'user' => ['columns' => ['__user_id']],
        ]);
    }

    public function down()
    {
        $this->dropTable('__user_sessions');
        $this->dropTable('__user_roles_to_users');
        $this->dropTable('__user_roles');
        $this->dropTable('__users');
    }
}