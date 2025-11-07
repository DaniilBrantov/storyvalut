<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Новое сообщение - StoryValut';
?>
<div class="site-create-post">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="card-title h4 mb-0">Создать новое сообщение</h1>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger">
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php $form = ActiveForm::begin(['id' => 'post-form']); ?>

                        <?= $form->field($model, 'message')->textarea([
                            'rows' => 8,
                            'placeholder' => 'Расскажите свою историю... (минимум 5 символов, максимум 1000)'
                        ])->label('Ваше сообщение') ?>

                        <div class="alert alert-info">
                            <small>
                                <strong>Разрешенные HTML-теги:</strong> &lt;b&gt;, &lt;i&gt;, &lt;s&gt;<br>
                                <strong>Ограничение:</strong> 1 сообщение в 3 минуты
                            </small>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Опубликовать сообщение', [
                                'class' => 'btn btn-primary btn-lg w-100'
                            ]) ?>
                            <?= Html::a('Отмена', ['site/index'], [
                                'class' => 'btn btn-outline-secondary w-100 mt-2'
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>