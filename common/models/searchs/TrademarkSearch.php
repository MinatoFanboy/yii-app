<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use common\models\myAPI;
use common\models\Trademark;
use yii\data\ActiveDataProvider;

class TrademarkSearch extends Trademark
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug', 'file', 'active'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Trademark::find()->andWhere(['active' => myAPI::ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
