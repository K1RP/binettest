<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180821_071515_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
			'username' => $this->string()->unique(),
			'password' => $this->string()->defaultValue(0),
			'refid' => this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
