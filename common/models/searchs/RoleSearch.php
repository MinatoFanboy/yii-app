<?php

namespace common\models\searchs;

use common\models\myAPI;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Role;

class RoleSearch extends Role
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Role::find()->andFilterWhere(['status' => myAPI::ACTIVE]);

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

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
