<?php

namespace App\Controllers;

use T4\Mvc\Controller;

class Post
    extends Controller
{
    public function actionAll()
    {
        $this->data->items = \App\Models\Post::findAll(['order' => 'published desc']);
    }
    
    public function actionOne($id = 0)
    {
        $item = \App\Models\Post::findByPK($id);
        if (false == $item) {
            $this->redirect('/error/404/');
        }
        $this->data->item = $item;
        $this->data->message = $this->app->flash->message;
    }
}