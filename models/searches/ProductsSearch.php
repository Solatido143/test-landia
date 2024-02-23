<?php

namespace app\models\searches;

use app\models\Products;
use yii\data\ActiveDataProvider;

/**
 * ProductsSearch represents the model behind the search form of `app\models\Products`.
 */
class ProductsSearch extends Products
{
    public $searchField; // Define a new attribute to hold the combined search field

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['searchField'], 'safe'], // Make the search field safe for input
        ];
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // Adjust the query to search for records where any of the specified fields closely match the user input
        $query->andFilterWhere(['or',
            ['like', 'id', $this->searchField],
            ['like', 'name', $this->searchField],
            ['like', 'description', $this->searchField],
            ['like', 'price', $this->searchField],
            ['like', 'stock_quantity', $this->searchField],
        ]);

        return $dataProvider;
    }
}
