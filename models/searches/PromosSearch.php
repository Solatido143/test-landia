<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promos;

/**
 * PromosSearch represents the model behind the search form of `app\models\Promos`.
 */
class PromosSearch extends Promos
{
    public $searchQuery;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'percentage'], 'integer'],
            [['promo', 'expiration_date', 'searchQuery'], 'safe'],
            [['minimum_amount'], 'number'],
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
        $query = Promos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['or',
            ['like', 'promo', $this->searchQuery],
            ['like', 'expiration_date', $this->searchQuery],
            ['like', 'percentage', $this->searchQuery],  // Make sure the table prefix is correct
            ['like', 'minimum_amount', $this->searchQuery],
            ['like', 'expiration_date', $this->searchQuery],
        ]);

        $query->andWhere(['>=', 'expiration_date', date('Y-m-d')]);

        return $dataProvider;
    }
}
