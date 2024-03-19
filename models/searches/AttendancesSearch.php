<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Attendances as AttendancesModel;

/**
 * AttendancesSearch represents the model behind the search form of `app\models\AttendancesSearch`.
 */
class AttendancesSearch extends AttendancesModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_employee'], 'integer'],
            [['sign_in', 'sign_out', 'remarks', 'sign_in_log', 'sign_out_log'], 'safe'],
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
        $query = AttendancesModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Adjust the number of items shown per page
            ],
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
            'fk_employee' => $this->fk_employee,
        ]);

        $query->andFilterWhere(['like', 'sign_in', $this->sign_in])
            ->andFilterWhere(['like', 'sign_out', $this->sign_out])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'sign_in_log', $this->sign_in_log])
            ->andFilterWhere(['like', 'sign_out_log', $this->sign_out_log]);

        return $dataProvider;
    }
}
