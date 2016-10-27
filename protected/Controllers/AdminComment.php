<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;
use T4\Mvc\Controller;

class AdminComment
    extends Controller
{
    public function access($action)
    {
        $user = $this->app->user;
        if (null == $user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isModerator() && 'Edit' == $action) {
            return true;
        }

        if ($user->isModerator() && 'Default' == $action) {
            return true;
        }

        if ($user->isModerator() && 'Show' == $action) {
            return true;
        }

        return false;
    }

    public function actionDefault()
    {

    }

    public function actionShow(int $id_post = null)
    {
        if (null != $id_post) {
            $this->data->comments = Comment::findAll([
                'where' => '__post_id=' . $id_post,
                'order' => 'published desc',
            ]);
            $this->data->id = $id_post;
        }
        $this->data->message = $this->app->flash->message;
        $this->data->items = Post::findAll(['order' => 'published desc']);
    }

    public function actionEdit($id = 0)
    {
        $comment = Comment::findByPK($id);
        if (null != $comment) {
            $comment->body = $this->app->request->post->body;
        }
        $comment->save();
        $this->app->flash->message = 'Комментарий успешно отредактирован!';
        $this->redirect('/adminComment/show?id_post=' . $comment->post->getPk());
    }

    public function actionDelete($id = 0)
    {
        $comment = Comment::findByPK($id);
        if (null != $comment) {
            $comment->delete();
        }
        $this->app->flash->message = 'Комментарий успешно удалён!';
        $this->redirect('/adminComment/show?id_post=' . $comment->post->getPk());
    }
}