<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int|null $order_id
 * @property string $user_name
 * @property string $user_phone
 * @property int $warehouse_id
 * @property int $status
 * @property int $items_count
 * @property int $created_at
 * @property int $updated_at
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'warehouse_id', 'status', 'items_count', 'created_at', 'updated_at'], 'integer'],
            [['user_name', 'user_phone', 'warehouse_id', 'created_at', 'updated_at'], 'required'],
            [['user_name'], 'string', 'max' => 255],
            [['user_phone'], 'string', 'max' => 32],
            [['order_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'warehouse_id' => 'Warehouse ID',
            'status' => 'Status',
            'items_count' => 'Items Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
