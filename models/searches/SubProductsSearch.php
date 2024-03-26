<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubProducts;

/**
 * SubProductsSearch represents the model behind the search form of `app\models\SubProducts`.
 */
class SubProductsSearch extends SubProducts
{
    public $searchField;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'quantity'], 'integer'],
            [['sub_products_name', 'description'], 'safe'],
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
        $query = SubProducts::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'sub_products_name', $this->searchField])
            ->andFilterWhere(['like', 'description', $this->searchField]);

        return $dataProvider;
    }
}
