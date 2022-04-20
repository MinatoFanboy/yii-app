<?php

namespace common\models;

use Yii;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $short_description
 * @property string|null $description
 * @property float|null $cost
 * @property float|null $price
 * @property float|null $price_sale
 * @property string|null $exist_day
 * @property int|null $features
 * @property int|null $newest
 * @property int|null $sellest
 * @property int|null $trademark_id
 * @property string|null $trademark
 * @property int|null $active
 * @property int|null $user_created_id
 * @property string|null $user_created
 * @property int|null $user_updated_id
 * @property string|null $user_updated
 *
 * @property ProductImage[] $productImages
 * @property ProductKeywork[] $productKeyworks
 */
class Product extends myActiveRecord
{
    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['description'], 'string'],
            [['cost', 'price', 'price_sale'], 'safe'],
            [['exist_day'], 'safe'],
            [['features', 'newest', 'sellest', 'trademark_id', 'active', 'user_created_id', 'user_updated_id'], 'integer'],
            [['name', 'trademark', 'user_created', 'user_updated'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên',
            'short_description' => 'Mô tả ngắn gọn',
            'description' => 'Mô tả chi tiết',
            'cost' => 'Giá nhập',
            'price' => 'Giá bán',
            'price_sale' => 'Giá cạnh tranh',
            'exist_day' => 'Ngày hàng về',
            'features' => 'Nổi bật',
            'newest' => 'Mới về',
            'sellest' => 'Bán chạy',
            'trademark_id' => 'Thương hiệu',
            'trademark' => 'Thương hiệu',
            'active' => 'Active',
            'user_created_id' => 'User Created ID',
            'user_created' => 'User Created',
            'user_updated_id' => 'User Updated ID',
            'user_updated' => 'User Updated',
        ];
    }

    public function getProductImages()
    {
        return $this->hasMany(ProductImage::className(), ['product_id' => 'id']);
    }

    public function getProductKeyworks()
    {
        return $this->hasMany(ProductKeywork::className(), ['product_id' => 'id']);
    }
}
