<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $id
 * @property int $fk_booking
 * @property string $mode_of_payment
 * @property float $payment_amount
 * @property int $fk_promo
 * @property float $discount
 * @property string $payment_date
 * @property string $logged_by
 * @property string $logged_time
 *
 * @property Bookings $fkBooking
 * @property Promos $fkPromo
 */
class Payments extends \yii\db\ActiveRecord
{
    public $change;
    public $amount_tendered;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_booking', 'mode_of_payment', 'payment_amount', 'discount', 'payment_date', 'logged_by', 'logged_time'], 'required'],
            [['fk_booking', 'fk_promo'], 'integer'],
            [['mode_of_payment'], 'string'],
            [['payment_amount', 'discount', 'amount_tendered'], 'number', 'min' => 0],
            [['payment_date', 'logged_by', 'logged_time'], 'string', 'max' => 255],
            [['fk_booking'], 'exist', 'skipOnError' => true, 'targetClass' => Bookings::class, 'targetAttribute' => ['fk_booking' => 'id']],
            [['fk_promo'], 'exist', 'skipOnError' => true, 'targetClass' => Promos::class, 'targetAttribute' => ['fk_promo' => 'id']],
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_booking' => 'Fk Booking',
            'mode_of_payment' => 'Mode Of Payment',
            'payment_amount' => 'Payment Amount',
            'fk_promo' => 'Promo',
            'discount' => 'Discount',
            'payment_date' => 'Payment Date',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
        ];
    }

    /**
     * Gets query for [[FkBooking]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsQuery
     */
    public function getFkBooking()
    {
        return $this->hasOne(Bookings::class, ['id' => 'fk_booking']);
    }
    /**
     * Gets query for [[FkPromo]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PromosQuery
     */
    public function getFkPromo()
    {
        return $this->hasOne(Promos::class, ['id' => 'fk_promo']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentsQuery(get_called_class());
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }
}
