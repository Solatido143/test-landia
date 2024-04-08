<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Attendances as AttendancesModel;
use app\models\Employees;

/**
 * AttendancesSearch represents the model behind the search form of `app\models\Attendances`.
 */
class AttendancesSearch extends AttendancesModel
{
    public $searchQuery;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_employee'], 'integer'],
            [['sign_in', 'sign_out', 'remarks', 'sign_in_log', 'sign_out_log', 'searchQuery'], 'safe'],
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
        $query = AttendancesModel::find()->joinWith('fkEmployee'); // Corrected here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->attributes['searchQuery'] = [
            'asc' => ['employees.fname' => SORT_ASC, 'employees.lname' => SORT_ASC],
            'desc' => ['employees.fname' => SORT_DESC, 'employees.lname' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['or',
            ['like', 'fk_employee', $this->searchQuery],
        ]);

        return $dataProvider;
    }
}
