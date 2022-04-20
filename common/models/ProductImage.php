<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property string|null $file
 * @property int|null $product_id
 *
 * @property Product $product
 */
class ProductImage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'product_image';
    }

    public function rules()
    {
        return [
            [['file'], 'string'],
            [['product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File',
            'product_id' => 'Product ID',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
