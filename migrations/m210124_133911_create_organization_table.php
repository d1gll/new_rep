<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization}}`.
 */
class m210124_133911_create_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('new_xml', [
            'id' => $this->primaryKey(),
            'user' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'status' =>  $this->integer(11)->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('new_xml');
    }
}
