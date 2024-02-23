<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EmployeesSearch represents the model behind the search form of `app\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * @var string the attribute that will be used for searching.
     */
    public $searchField;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_position', 'fk_cluster', 'fk_region', 'fk_region_area', 'fk_city', 'availability'], 'integer'],
            [['employee_id', 'fname', 'mname', 'lname', 'suffix', 'bday', 'gender', 'contact_number', 'house_address', 'date_hired', 'end_of_contract', 'fk_employment_status', 'emergency_contact_persons', 'emergency_contact_numbers', 'emergency_contact_relations', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'searchField'], 'safe'],
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
            'fk_position' => $this->fk_position,
            'fk_cluster' => $this->fk_cluster,
            'fk_region' => $this->fk_region,
            'fk_region_area' => $this->fk_region_area,
            'fk_city' => $this->fk_city,
            'availability' => $this->availability,
        ]);

        $query->andFilterWhere(['like', 'employee_id', $this->searchField])
            ->orFilterWhere(['like', 'fname', $this->searchField])
            ->orFilterWhere(['like', 'mname', $this->searchField])
            ->orFilterWhere(['like', 'lname', $this->searchField])
            ->orFilterWhere(['like', 'suffix', $this->searchField])
            ->orFilterWhere(['like', 'bday', $this->searchField])
            ->orFilterWhere(['like', 'gender', $this->searchField])
            ->orFilterWhere(['like', 'contact_number', $this->searchField])
            ->orFilterWhere(['like', 'house_address', $this->searchField])
            ->orFilterWhere(['like', 'date_hired', $this->searchField])
            ->orFilterWhere(['like', 'end_of_contract', $this->searchField])
            ->orFilterWhere(['like', 'fk_employment_status', $this->searchField])
            ->orFilterWhere(['like', 'emergency_contact_persons', $this->searchField])
            ->orFilterWhere(['like', 'emergency_contact_numbers', $this->searchField])
            ->orFilterWhere(['like', 'emergency_contact_relations', $this->searchField])
            ->orFilterWhere(['like', 'logged_by', $this->searchField])
            ->orFilterWhere(['like', 'logged_time', $this->searchField])
            ->orFilterWhere(['like', 'updated_by', $this->searchField])
            ->orFilterWhere(['like', 'updated_time', $this->searchField]);

        return $dataProvider;
    }
}
