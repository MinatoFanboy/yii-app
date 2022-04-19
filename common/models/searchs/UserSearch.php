<?php

namespace common\models\searchs;

use common\models\myAPI;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    public function rules()
    {
        return [
            [['username', 'password_hash', 'status'], 'safe'],
            [['email'], 'safe'],
            [['created_at', 'updated_at'], 'safe'],
            [['password_reset_token', 'verification_token'], 'safe'],
            [['auth_key'], 'safe'],
            [['name'], 'safe'],
            [['phone'], 'safe'],
            [['role'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()->select(['username', 'name', 'phone', 'email', 'status', 'created_at', 'id', 'role']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if($this->created_at) {
            $this->created_at = myAPI::convertDateSaveIntoDb($this->created_at);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'date(created_at)' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'role', $this->role]);

        return $dataProvider;
    }
}
