<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Вы не можете редактировать это сообщение.');
        }

        if (!$model->canEdit()) {
            Yii::$app->session->setFlash('error', 
                'Редактирование сообщения доступно только в течение 12 часов после публикации.'
            );
            return $this->redirect(['site/index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Сообщение успешно обновлено.');
            return $this->redirect(['site/index']);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionConfirmDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Вы не можете удалить это сообщение.');
        }

        if (!$model->canDelete()) {
            Yii::$app->session->setFlash('error', 
                'Удаление сообщения доступно только в течение 14 дней после публикации.'
            );
            return $this->redirect(['site/index']);
        }

        return $this->render('confirm-delete', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->user_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Вы не можете удалить это сообщение.');
        }

        if (!$model->canDelete()) {
            Yii::$app->session->setFlash('error', 
                'Удаление сообщения доступно только в течение 14 дней после публикации.'
            );
            return $this->redirect(['site/index']);
        }

        if ($model->softDelete()) {
            Yii::$app->session->setFlash('success', 'Сообщение успешно удалено.');
        } else {
            Yii::$app->session->setFlash('error', 'Произошла ошибка при удалении сообщения.');
        }

        return $this->redirect(['site/index']);
    }

    protected function findModel($id)
    {
        $model = Post::find()
            ->where(['id' => $id, 'deleted_at' => null])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException('Сообщение не найдено.');
        }

        return $model;
    }
}