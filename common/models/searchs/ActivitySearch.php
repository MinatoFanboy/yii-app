<?php

namespace common\models\searchs;

use Yii;
use yii\base\Model;
use common\models\Activity;
use yii\data\ActiveDataProvider;

class ActivitySearch extends Activity
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'controller_action', 'group'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Activity::find();

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
            ->andFilterWhere(['like', 'controller_action', $this->controller_action])
            ->andFilterWhere(['like', 'group', $this->group]);

        return $dataProvider;
    }
}
