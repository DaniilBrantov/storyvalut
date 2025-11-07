<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */

$this->title = 'Регистрация - StoryValut';
?>
<div class="site-signup">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="card-title h4 mb-0 text-center">Регистрация в StoryValut</h1>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                        <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                            'placeholder' => 'Придумайте имя пользователя (2-15 символов)'
                        ]) ?>

                        <?= $form->field($model, 'email')->textInput([
                            'type' => 'email',
                            'placeholder' => 'your@email.com'
                        ]) ?>

                        <?= $form->field($model, 'password')->passwordInput([
                            'placeholder' => 'Придумайте пароль (минимум 6 символов)'
                        ]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Зарегистрироваться', [
                                'class' => 'btn btn-primary btn-lg w-100',
                                'name' => 'signup-button'
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                        <div class="text-center mt-3">
                            <p>Уже есть аккаунт? <?= Html::a('Войдите', ['site/login']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>