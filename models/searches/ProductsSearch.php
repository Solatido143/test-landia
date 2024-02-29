<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    public $searchQuery; // Define a new property to hold the search query

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stock_quantity', 'isRemove'], 'integer'],
            [['product_name', 'description', 'searchQuery'], 'safe'],
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
        $query = Products::find();

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
            'stock_quantity' => $this->stock_quantity,
        ]);

        // Perform a generalized search across multiple attributes
        $query->andFilterWhere(['or',
            ['like', 'product_name', $this->searchQuery],
            ['like', 'id', $this->searchQuery],
            ['like', 'description', $this->searchQuery],
        ]);

        return $dataProvider;
    }
}
