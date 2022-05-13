<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property int|null $customer_id
 * @property float|null $total
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property User $customer
 * @property OrderDetail[] $orderDetails
 */
class Order extends myActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'total' => 'Tổng tiền',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'id']);
    }
}
