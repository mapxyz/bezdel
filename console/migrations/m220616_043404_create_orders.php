<?php

use yii\db\Migration;

/**
 * Class m220616_043404_create_orders
 */
class m220616_043404_create_orders extends Migration
{
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%orders}}', [
			'id' => $this->primaryKey(),
			'order_id' => $this->integer()->unique(),
			'user_name' => $this->string()->notNull(),
			'user_phone' => $this->string(32)->notNull(),
			'warehouse_id' => $this->integer()->notNull(),
			'status' => $this->smallInteger()->notNull()->defaultValue(10),
			'items_count' => $this->smallInteger()->notNull()->defaultValue(1),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
		], $tableOptions);

		$this->createIndex(
			'idx-order',
			'orders',
			'order_id'
		);
	}


	public function down()
	{
		$this->dropTable('{{%orders}}');
	}
}
