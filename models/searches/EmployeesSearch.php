<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form of `app\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    public $searchQuery;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_position', 'fk_cluster', 'fk_region', 'fk_region_area', 'fk_city', 'fk_employment_status', 'availability'], 'integer'],
            [['employee_id', 'fname', 'mname', 'lname', 'suffix', 'bday', 'gender', 'contact_number', 'house_address', 'date_hired', 'end_of_contract', 'emergency_contact_persons', 'emergency_contact_numbers', 'emergency_contact_relations', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'searchQuery'], 'safe'], // Include searchField in the rules
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
        $query = Employees::find();

        $query->joinWith('fkPosition');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter based on searchField
        $query->andFilterWhere(['or',
            ['like', 'employee_id', $this->searchQuery],
            ['like', 'fname', $this->searchQuery],
            ['like', 'mname', $this->searchQuery],
            ['like', 'lname', $this->searchQuery],
            ['like', 'position', $this->searchQuery],
        ]);

        return $dataProvider;
    }
}
