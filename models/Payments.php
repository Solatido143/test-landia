<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
 * @property Promos $fkPromo
 */
class Payments extends \yii\db\ActiveRecord
{
    public $change;
    public $amount_tendered;
    public $total_due;
    public $special;
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
            [['fk_booking', 'mode_of_payment', 'payment_amount', 'discount', 'payment_date', 'logged_by', 'logged_time', 'amount_tendered'], 'required'],
            [['fk_booking', 'promo'], 'integer'],
            [['mode_of_payment'], 'string'],
            [['payment_amount', 'amount_tendered', 'change'], 'number', 'min' => 0],
            [['discount'], 'number'],
            [['payment_date', 'logged_by', 'logged_time'], 'string', 'max' => 255],
            [['fk_booking'], 'exist', 'skipOnError' => true, 'targetClass' => Bookings::class, 'targetAttribute' => ['fk_booking' => 'id']],
            [['promo'], 'exist', 'skipOnError' => true, 'targetClass' => Promos::class, 'targetAttribute' => ['promo' => 'id']],
            ['amount_tendered', 'compare', 'compareAttribute' => 'total_due', 'operator' => '>=', 'type' => 'number', 'message' => 'Amount tendered must be greater than or equal to Total due.'],
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
     * Gets query for [[FkPromo]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PromosQuery
     */
    public function getFkPromo()
    {
        return $this->hasOne(Promos::class, ['id' => 'promo']);
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
        return ArrayHelper::map($data, $valueField, $textField);
    }
}
