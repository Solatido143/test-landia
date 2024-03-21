<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bookings;
use yii\db\Expression;

/**
 * BookingsSearch represents the model behind the search form of `app\models\Bookings`.
 */
class BookingsSearch extends Bookings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_customer', 'fk_booking_status'], 'integer'],
            [['booking_type', 'schedule_time', 'remarks', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'safe'],
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
        $query = Bookings::find();

        // add conditions that should always apply here

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
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Filter to show bookings for today's date or past dates with fk_booking_status of 2
        $query->andFilterWhere([
            'or',
            ['=', 'DATE(logged_time)', date('Y-m-d')], // Today's date
            ['and', ['<', 'logged_time', date('Y-m-d 00:00:00')], ['fk_booking_status' => 2]], // Past dates with fk_booking_status of 2
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_customer' => $this->fk_customer,
//            'fk_booking_status' => $this->fk_booking_status,
        ]);

        $query->andFilterWhere(['like', 'booking_type', $this->booking_type])
            ->andFilterWhere(['like', 'schedule_time', $this->schedule_time])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'logged_by', $this->logged_by])
            ->andFilterWhere(['like', 'logged_time', $this->logged_time])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'updated_time', $this->updated_time]);

        return $dataProvider;
    }
}
