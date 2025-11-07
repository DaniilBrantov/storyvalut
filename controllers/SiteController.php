<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\User;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'create-post'],
                'rules' => [
                    [
                        'actions' => ['logout', 'create-post'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'signup', 'index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()
                ->joinWith('user')
                ->where(['deleted_at' => null])
                ->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно. Теперь вы можете войти.');
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionCreatePost()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            if (!Post::canPostFromUser(Yii::$app->user->id)) {
                $nextPostTime = Post::getNextPostTimeForUser(Yii::$app->user->id);
                Yii::$app->session->setFlash('error', 
                    "Вы можете отправить следующее сообщение через " . 
                    Yii::$app->formatter->asRelativeTime($nextPostTime)
                );
            } else {
                $model->user_id = Yii::$app->user->id;
                $model->author_ip = Yii::$app->request->getUserIP();
                
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Сообщение успешно опубликовано!');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create-post', [
            'model' => $model,
        ]);
    }
}