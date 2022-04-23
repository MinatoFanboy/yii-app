<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use common\models\myAPI;
use common\models\Product;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    public function rules()
    {
        return [
            [['id', 'features', 'newest', 'sellest', 'trademark_id', 'user_created_id', 'user_updated_id', 'active'], 'integer'],
            [['name', 'short_description', 'description', 'exist_day', 'trademark_name', 'user_created', 'user_updated'], 'safe'],
            [['cost', 'price', 'price_sale'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find()->andWhere(['active' => myAPI::ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'cost' => $this->cost,
            'price' => $this->price,
            'price_sale' => $this->price_sale,
            'exist_day' => $this->exist_day,
            'features' => $this->features,
            'newest' => $this->newest,
            'sellest' => $this->sellest,
            'trademark_id' => $this->trademark_id,
            'user_created_id' => $this->user_created_id,
            'user_updated_id' => $this->user_updated_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'trademark_name', $this->trademark_name])
            ->andFilterWhere(['like', 'user_created', $this->user_created])
            ->andFilterWhere(['like', 'user_updated', $this->user_updated]);

        return $dataProvider;
    }
}
