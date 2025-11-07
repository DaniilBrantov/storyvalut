<?php

use yii\helpers\Html;

/** @var app\models\Post $model */
/** @var yii\web\View $this */

$ip = $model->author_ip;

if (strpos($ip, '.') !== false) {
    $parts = explode('.', $ip);
    if (count($parts) >= 2) {
        $formattedIp = $parts[0] . '.' . $parts[1] . '.**.**';
    } else {
        $formattedIp = '***.***.***.***';
    }
} else {
    if ($ip === '::1') {
        $formattedIp = '::**** (localhost)';
    } else {
        $parts = explode(':', $ip);
        $formattedParts = [];
        
        for ($i = 0; $i < count($parts); $i++) {
            if ($i < 2 && !empty($parts[$i])) {
                $formattedParts[] = $parts[$i];
            } else {
                $formattedParts[] = '****';
            }
        }
        
        $formattedIp = implode(':', $formattedParts);
        
        if (substr_count($formattedIp, '****') > 4) {
            $formattedParts = array_slice($formattedParts, 0, 4);
            $formattedIp = implode(':', $formattedParts) . ':****:****';
        }
    }
}


$postsCount = $model->getAuthorPostsCount();
?>

<div class="card card-default mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= Html::encode($model->user->username) ?></h5>
        <div class="card-text post-message">
            <?= $model->message ?>
        </div>
        <p class="mt-3 mb-0">
            <small class="text-muted">
                <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?> |
                <?= $formattedIp ?> | 
                <?= Yii::t('app', '{n, plural, =0{нет постов} one{# пост} few{# поста} many{# постов} other{# поста}}', ['n' => $postsCount]) ?>
                
                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id === $model->user_id): ?>
                    | 
                    <?php if ($model->canEdit()): ?>
                        <?= Html::a('Редактировать', ['post/edit', 'id' => $model->id], ['class' => 'text-primary']) ?>
                    <?php endif; ?>
                    
                    <?php if ($model->canDelete()): ?>
                        <?= Html::a('Удалить', ['post/confirm-delete', 'id' => $model->id], ['class' => 'text-danger ms-2']) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </small>
        </p>
    </div>
</div>