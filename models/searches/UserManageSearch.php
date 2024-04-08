<?php

namespace app\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserManageSearch represents the model behind the search form of `app\models\User`.
 */
class UserManageSearch extends User
{
    public $searchQuery;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'availability'], 'integer'],
            [['searchQuery'], 'string'],
            [['username', 'fk_employee_id', 'email', 'password_hash', 'password_reset_token', 'user_access', 'created_at', 'updated_at', 'auth_key', 'verification_token', 'managers_code'], 'safe'],

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
        $query = User::find();

        // Exclude records where user_access is 6
        $query->where(['not', ['user_access' => 6]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['or',
            ['like', 'username', $this->searchQuery],
            ['like', 'fk_employee_id', $this->searchQuery],
            ['like', 'email', $this->searchQuery]
        ]);

        return $dataProvider;
    }
}
