<?php


use yii\db\Migration;

class m150930_205859_fix_default extends Migration
{

    public function up()
    {
        $this->alterColumn('dislike', 'target_user_id', 'int(11) DEFAULT NULL');
    }

    public function down()
    {
        echo "m150930_205859_fix_default does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
