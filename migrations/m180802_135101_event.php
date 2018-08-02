<?php

use yii\db\Migration;

/**
 * Class m180802_135101_event
 */
class m180802_135101_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event', [
            'id' => $this->primaryKey(),
            'nameEvent' => $this->string()->notNull(),
            'dayEvent' => $this->date()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('event');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180802_135101_event cannot be reverted.\n";

        return false;
    }
    */
}
