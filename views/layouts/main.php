<?php

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => 'StoryValut',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-lg navbar-dark bg-dark'],
]);

$menuItems = [];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
} else {
    $menuItems[] = ['label' => 'Написать', 'url' => ['/site/create-post']];
    $menuItems[] = ['label' => 'Выйти (' . Yii::$app->user->identity->username . ')', 
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}

echo Nav::widget([
    'options' => ['class' => 'navbar-nav ms-auto'],
    'items' => $menuItems,
]);
NavBar::end();
?>

<main class="container-fluid py-4">
    <?= $content ?>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="text-center text-muted">
            <p>&copy; StoryValut <?= date('Y') ?></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>