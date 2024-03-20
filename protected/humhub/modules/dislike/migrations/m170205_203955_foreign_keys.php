<?php

use yii\db\Schema;
use yii\db\Migration;

class m170205_203955_foreign_keys extends Migration
{

    public function up()
    {
        try {
            $this->addForeignKey('fk_dislike-created_by', 'dislike', 'created_by', 'user', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_dislike-target_user_id', 'dislike', 'target_user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_dislike-created_by', 'dislike');
        $this->dropForeignKey('fk_dislike-target_user_id', 'dislike');

        return true;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
