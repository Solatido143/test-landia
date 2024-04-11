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
    public $searchQuery;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_customer', 'fk_booking_status'], 'integer'],
            [['searchQuery', 'booking_type', 'schedule_time', 'remarks', 'logged_by', 'logged_time', 'updated_by', 'updated_time', 'fk_booking_status'], 'safe'],
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

        $query->joinWith('fkCustomer');
        $query->joinWith('fkBookingStatus');

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

        // Modify the filter conditions to explicitly specify the table prefix
        $query->andFilterWhere([
            'or',
            ['=', 'DATE(bookings.logged_time)', date('Y-m-d')],
            ['and', ['<', 'bookings.logged_time', date('Y-m-d 00:00:00')], ['bookings.fk_booking_status' => 2]],
        ]);


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'fk_customer' => $this->fk_customer,
            'fk_booking_status' => $this->fk_booking_status,
        ]);

        // Perform a generalized search across multiple attributes
        $query->andFilterWhere(['or',
            ['like', 'bookings.booking_type', $this->searchQuery],
            ['like', 'bookings_status.booking_status', $this->searchQuery],
            ['like', 'customers.customer_name', $this->searchQuery],  // Make sure the table prefix is correct
            ['like', 'bookings.schedule_time', $this->searchQuery],
            ['like', 'bookings.remarks', $this->searchQuery],
        ]);

        return $dataProvider;
    }
}
