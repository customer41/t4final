<?php

namespace App\Controllers;

use T4\Core\MultiException;
use T4\Mvc\Controller;

class Comment
    extends Controller
{
    public function actionShow($id_post = 0)
    {
        $this->data->items = \App\Models\Comment::findAll([
            'where' => '__post_id=' . $id_post,
            'order' => 'published desc',
        ]);
    }

    public function actionAdd($id_post = 0)
    {
        $this->data->id_post = $id_post;
    }

    public function actionSave($id_post = 0)
    {
        try {
            $comment = new \App\Models\Comment();
            $comment->fill(['body' => $this->app->request->post->body]);
            $comment->published = date('Y-m-d H:i:s');
            $comment->author = $this->app->user;
            $comment->post = \App\Models\Post::findByPK($id_post);
            $comment->save();
            $this->redirect('/post/one?id=' . $id_post);
        } catch (MultiException $e) {
            $this->app->flash->message = $e[0]->getMessage();
            $this->redirect('/post/one?id=' . $id_post);
        }
    }
}