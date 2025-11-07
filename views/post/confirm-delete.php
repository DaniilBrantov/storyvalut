<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Подтверждение удаления - StoryValut';
?>
<div class="post-confirm-delete">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="card-title h4 mb-0">Подтверждение удаления</h1>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (!$model->canDelete()): ?>
                            <div class="alert alert-warning">
                                Время для удаления истекло (доступно 14 дней с момента публикации).
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <h5>Вы уверены, что хотите удалить это сообщение?</h5>
                                <p class="mb-0">Это действие нельзя будет отменить.</p>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title"><?= Html::encode($model->user->username) ?></h6>
                                    <div class="card-text">
                                        <?= $model->message ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= Html::a('Удалить сообщение', ['post/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Вы точно хотите удалить это сообщение?',
                                    ]
                                ]) ?>
                                <?= Html::a('Отмена', ['site/index'], [
                                    'class' => 'btn btn-outline-secondary'
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>