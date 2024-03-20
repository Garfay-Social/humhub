<?php


use humhub\components\Migration;
use humhub\modules\like\models\Dislike;

class m160704_005434_namespace extends Migration
{

    public function up()
    {
        $this->renameClass('Dislike', Dislike::class);
    }

    public function down()
    {
        echo "m160704_005434_namespace cannot be reverted.\n";

        return false;
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
