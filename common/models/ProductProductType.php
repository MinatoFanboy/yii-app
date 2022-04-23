<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property int|null $product_id
 * @property int|null $product_type_id
 *
 * @property Product $product
 * @property ProductType $productType
 */
class ProductProductType extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'product_product_type';
    }

    public function rules()
    {
        return [
            [['product_id', 'product_type_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['product_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['product_type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'product_type_id' => 'Product Type ID',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'product_type_id']);
    }
}
