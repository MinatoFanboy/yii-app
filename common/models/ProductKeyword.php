<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property int|null $product_id
 * @property int|null $keyword_id
 *
 * @property Keyword $keyword
 * @property Product $product
 */
class ProductKeyword extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'product_keyword';
    }

    public function rules()
    {
        return [
            [['product_id', 'keyword_id'], 'integer'],
            [['keyword_id'], 'exist', 'skipOnError' => true, 'targetClass' => Keyword::className(), 'targetAttribute' => ['keyword_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'keyword_id' => 'Keyword ID',
        ];
    }

    public function getKeyword()
    {
        return $this->hasOne(Keyword::className(), ['id' => 'keyword_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
