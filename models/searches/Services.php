<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Services as ServicesModel;

/**
 * services represents the model behind the search form of `app\models\services`.
 */
class Services extends ServicesModel
{
    public $searchQuery;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'completion_time'], 'integer'],
            [['service_name', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'availability'], 'safe'],
            [['service_fee'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ServicesModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, // Set the page size to 5
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_fee' => $this->service_fee,
            'completion_time' => $this->completion_time,
        ]);

        $query->andFilterWhere(['like', 'service_name', $this->service_name])
            ->andFilterWhere(['like', 'logged_by', $this->logged_by])
            ->andFilterWhere(['like', 'logged_time', $this->logged_time])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'updated_time', $this->updated_time]);

        return $dataProvider;
    }
}
