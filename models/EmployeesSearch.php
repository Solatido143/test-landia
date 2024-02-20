<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form of `app\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_position', 'fk_cluster', 'fk_region', 'fk_region_area', 'fk_city', 'availability'], 'integer'],
            [['employee_id', 'fname', 'mname', 'lname', 'suffix', 'bday', 'gender', 'contact_number', 'house_address', 'date_hired', 'end_of_contract', 'employment_status', 'emergency_contact_persons', 'emergency_contact_numbers', 'emergency_contact_relations', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'safe'],
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

        $query->andFilterWhere(['like', 'employee_id', $this->employee_id])
            ->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'suffix', $this->suffix])
            ->andFilterWhere(['like', 'bday', $this->bday])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'contact_number', $this->contact_number])
            ->andFilterWhere(['like', 'house_address', $this->house_address])
            ->andFilterWhere(['like', 'date_hired', $this->date_hired])
            ->andFilterWhere(['like', 'end_of_contract', $this->end_of_contract])
            ->andFilterWhere(['like', 'employment_status', $this->employment_status])
            ->andFilterWhere(['like', 'emergency_contact_persons', $this->emergency_contact_persons])
            ->andFilterWhere(['like', 'emergency_contact_numbers', $this->emergency_contact_numbers])
            ->andFilterWhere(['like', 'emergency_contact_relations', $this->emergency_contact_relations])
            ->andFilterWhere(['like', 'logged_by', $this->logged_by])
            ->andFilterWhere(['like', 'logged_time', $this->logged_time])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'updated_time', $this->updated_time]);

        return $dataProvider;
    }
}
