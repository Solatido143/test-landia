<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promos".
 *
 * @property int $id
 * @property string $promo
 * @property int $percentage
 * @property float $minimum_amount
 * @property string $expiration_date
 */
class Promos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'promos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promo', 'percentage', 'minimum_amount', 'expiration_date'], 'required'],
            [['percentage'], 'integer'],
            [['minimum_amount'], 'number'],
            [['promo', 'expiration_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'promo' => 'Promo',
            'percentage' => 'Percentage',
            'minimum_amount' => 'Minimum Amount',
            'expiration_date' => 'Expiration Date',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PromosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PromosQuery(get_called_class());
    }
}
