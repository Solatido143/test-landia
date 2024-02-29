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
 * @property int $promo
 * @property float $discount
 * @property string $payment_date
 * @property string $logged_by
 * @property string $logged_time
 *
 * @property Bookings $fkBooking
 */
class Payments extends \yii\db\ActiveRecord
{
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
            [['fk_booking', 'mode_of_payment', 'payment_amount', 'promo', 'discount', 'payment_date', 'logged_by', 'logged_time'], 'required'],
            [['fk_booking', 'promo'], 'integer'],
            [['mode_of_payment'], 'string'],
            [['payment_amount', 'discount'], 'number'],
            [['payment_date', 'logged_by', 'logged_time'], 'string', 'max' => 255],
            [['fk_booking'], 'exist', 'skipOnError' => true, 'targetClass' => Bookings::class, 'targetAttribute' => ['fk_booking' => 'id']],
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
            'promo' => 'Promo',
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
     * {@inheritdoc}
     * @return \app\models\query\PaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PaymentsQuery(get_called_class());
    }
}
