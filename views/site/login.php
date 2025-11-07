<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

$this->title = 'Вход - StoryValut';
?>
<div class="site-login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="card-title h4 mb-0 text-center">Вход в StoryValut</h1>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Ваше имя пользователя'
                        ]) ?>

                        <?= $form->field($model, 'password')->passwordInput([
                            'placeholder' => 'Ваш пароль'
                        ]) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                        <div class="form-group">
                            <?= Html::submitButton('Войти', [
                                'class' => 'btn btn-primary btn-lg w-100',
                                'name' => 'login-button'
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <div class="text-center mt-3">
                            <p>Нет аккаунта? <?= Html::a('Зарегистрируйтесь', ['site/signup']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>