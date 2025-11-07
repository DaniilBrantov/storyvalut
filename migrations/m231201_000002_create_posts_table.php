<?php

use yii\db\Migration;

class m231201_000002_create_posts_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'author_ip' => $this->string(45)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->createIndex('idx-posts-user_id', '{{%posts}}', 'user_id');
        $this->createIndex('idx-posts-created_at', '{{%posts}}', 'created_at');
    }

    public function safeDown()
    {
        $this->dropTable('{{%posts}}');
    }
}