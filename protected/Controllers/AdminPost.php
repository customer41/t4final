<?php

namespace App\Controllers;

use App\Models\Post;
use T4\Mvc\Controller;

class AdminPost
    extends Controller
{
    protected function access($action)
    {
        $user = $this->app->user;
        if (null == $user) {
            return false;
        }
        if ($user->isAdmin()) {
            return true;
        }
        return false;
    }

    public function actionDefault()
    {
        
    }

    public function actionShow($id = 0)
    {
        if (null != $this->app->request->get->id) {
            $this->data->id = (int)$id;
        }
        $this->data->message = $this->app->flash->message;
        $this->data->items = Post::findAll(['order' => 'published desc']);
    }

    public function actionAdd($post = null)
    {
        if (null !== $post) {
            $subj = new Post();
            $subj->fill($post);
            $subj->published = date('Y-m-d H:i:s');
            $subj->author = $this->app->user;
            $subj->save();
            $this->app->flash->message = 'Пост успешно добавлен!';
            $this->redirect('/adminPost/show?id=' . $subj->getPk());
        }
    }

    public function actionDelete($id = 0)
    {
        $post = Post::findByPK($id);
        if (false != $post) {
            $post->delete();
            $this->app->flash->message = 'Пост успешно удалён!';
        }
        $this->redirect('/adminPost/show/');
    }
}