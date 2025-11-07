<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Редактирование сообщения - StoryValut';
?>
<div class="post-edit">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="card-title h4 mb-0">Редактирование сообщения</h1>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (!$model->canEdit()): ?>
                            <div class="alert alert-warning">
                                Время для редактирования истекло (доступно 12 часов с момента публикации).
                            </div>
                        <?php else: ?>
                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'message')->textarea([
                                'rows' => 8,
                                'placeholder' => 'Ваше сообщение...'
                            ])->label('Сообщение') ?>

                            <div class="form-group mt-4">
                                <?= Html::submitButton('Сохранить изменения', [
                                    'class' => 'btn btn-primary'
                                ]) ?>
                                <?= Html::a('Отмена', ['site/index'], [
                                    'class' => 'btn btn-outline-secondary'
                                ]) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>