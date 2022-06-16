<?php

namespace common\repository;

use common\models\Orders;
use yii\db\Query;

class OrderRepository
{
	public function getIssetIds(array $order_ids)
	{
		return (new Query())->select('order_id')->from(Orders::tableName())->where(['order_id' =>$order_ids])->all();
	}
}