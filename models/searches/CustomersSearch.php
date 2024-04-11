<?php
namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customers;

/**
 * CustomersSearch represents the model behind the search form of `app\models\Customers`.
 */
class CustomersSearch extends Customers
{
    public $searchQuery;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['customer_name', 'contact_number', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'searchQuery'], 'safe'],  // Add searchQuery rule
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // Bypass scenarios() implementation in the parent class
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
        $query = Customers::find();

        // Add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        // Perform a generalized search across multiple attributes
        $query->andFilterWhere(['or',
            ['like', 'customer_name', $this->searchQuery],
            ['like', 'contact_number', $this->searchQuery],
            ['like', 'logged_by', $this->searchQuery],
            ['like', 'logged_time', $this->searchQuery],
            ['like', 'updated_by', $this->searchQuery],
            ['like', 'updated_time', $this->searchQuery],
        ]);

        return $dataProvider;
    }
}
