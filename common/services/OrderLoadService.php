<?php

namespace common\services;

use common\models\Orders;
use common\repository\OrderRepository;
use yii\helpers\ArrayHelper;

class OrderLoadService
{
	private $data;
	private $insert = [];
	private $orders = [];
	public $orderRep;

	public function __construct(OrderRepository $rep)
	{
		$this->orderRep = $rep;
	}

	public function setData(array $data)
	{
		if (!count($data)) {
			throw new \Exception("file empty");
		}
		$this->data = $data;
	}

	public function load()
	{
		$this->getOrdersId();
		foreach ($this->data as $item) {
			$work_data = [
				'order_id' => $item['id'],
				'user_name' => $item['user_name'],
				'user_phone' => $item['user_phone'],
				'warehouse_id' => $item['warehouse_id'],
				'created_at' => strtotime($item['created_at']),
				'status' => $item['status'],
				'items_count' => isset($item['items']) && is_array($item['items']) ? count($item['items']) : 0,
			];

			if (isset($this->orders[$item['id']])) {
				//в реальности здесь конечно надо собрать отдельный массив и делать один запрос
				//по аналогии с добавлением
				$work_data['updated_at'] = new \yii\db\Expression('NOW()');
				Orders::updateAll($work_data, 'order_id = ' . $item['id']);
			} else {
				$this->insert[] = $work_data;
			}

		}
		$this->insert();
	}

	private function getOrdersId()
	{
		$ids = ArrayHelper::getColumn($this->data, 'id');
		$this->orders = ArrayHelper::index($this->orderRep->getIssetIds($ids), 'order_id');
	}

	private function insert()
	{
		if (count($this->insert)) {
			\Yii::$app->db->createCommand()->batchInsert(Orders::tableName(), [
				'order_id', 'user_name', 'user_phone', 'warehouse_id', 'created_at', 'status', 'items_count'
			], $this->insert)->execute();
		}
	}
}