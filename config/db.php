<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . dirname(__DIR__) . '/database/storyvalut.db',    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'schemaCache' => 'cache',
    'schemaCacheDuration' => 3600,
    'enableSchemaCache' => true,
];