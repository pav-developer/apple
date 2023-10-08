<?php

use yii\db\Migration;

/**
 * Class m231008_162126_create_apple
 */
class m231008_162126_create_apple extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
        // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%apple}}', [
        'id' => $this->primaryKey(),
        'color' => $this->string(),
        'size' => $this->decimal(3,2)->defaultValue(1),
        'created_date' => $this->integer()->notNull(),
        'fallen_date' => $this->integer(),
        'status' => $this->smallInteger(),
        'rotten' => $this->boolean()->defaultValue(0),
      ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('{{%apple}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231008_162126_create_apple cannot be reverted.\n";

        return false;
    }
    */
}
