<?php

namespace App\Controllers;

use T4\Mvc\Controller;

class Admin
    extends Controller
{
    protected function access($action)
    {
        $user = $this->app->user;
        if (null == $user) {
            return false;
        }
        if ($user->isAdmin() || $user->isModerator()) {
            return true;
        }
        return false;
    }

    public function actionDefault()
    {
        
    }
}