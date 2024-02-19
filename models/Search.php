<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class Search extends \yii\base\Model
{

    public $search;

    public function rules()
    {
        return [
            [['search'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user', $this->search]);

        return $dataProvider;
    }

}