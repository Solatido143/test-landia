<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Payments;

/**
 * PaymentsSearch represents the model behind the search form of `app\models\Payments`.
 */
class PaymentsSearch extends Payments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fk_booking', 'promo'], 'integer'],
            [['mode_of_payment', 'payment_date', 'logged_by', 'logged_time'], 'safe'],
            [['payment_amount', 'discount'], 'number'],
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
        $query = Payments::find();

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
            'fk_booking' => $this->fk_booking,
            'payment_amount' => $this->payment_amount,
            'promo' => $this->promo,
            'discount' => $this->discount,
        ]);

        $query->andFilterWhere(['like', 'mode_of_payment', $this->mode_of_payment])
            ->andFilterWhere(['like', 'payment_date', $this->payment_date])
            ->andFilterWhere(['like', 'logged_by', $this->logged_by])
            ->andFilterWhere(['like', 'logged_time', $this->logged_time]);

        return $dataProvider;
    }
}
