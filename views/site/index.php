<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'StoryValut - Поделитесь своей историей';
?>
<div class="site-index">
    <div class="jumbotron jumbotron-fluid bg-light rounded mb-4">
        <div class="container">
            <h1 class="display-4">StoryValut</h1>
            <p class="lead">Поделитесь своей историей с миром. Анонимно и безопасно.</p>
        </div>
    </div>

    <div class="container">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="mb-4">Последние сообщения</h2>
        
        <?php if ($dataProvider->getTotalCount() > 0): ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_post',
                'layout' => "{items}\n{pager}",
                'emptyText' => 'Пока нет сообщений.',
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center mt-4'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                ],
            ]) ?>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <h5 class="text-muted">Пока нет сообщений</h5>
                    <p class="text-muted">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <?= Html::a('Войдите', ['site/login']) ?> или <?= Html::a('зарегистрируйтесь', ['site/signup']) ?>, чтобы стать первым!
                        <?php else: ?>
                            <?= Html::a('Напишите первое сообщение', ['site/create-post']) ?>!
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>