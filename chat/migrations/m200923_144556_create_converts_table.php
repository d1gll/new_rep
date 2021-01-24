<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%converts}}`.
 */
class m200923_144556_create_converts_table extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('chats', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'text' => $this->string(255)->notNull(),
            'rules' => $this->string(255)->notNull(),
            'tdata' => $this->string(32)->notNull(),
            'access' => $this->boolean()->defaultValue(true),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('converts');
    }
}
