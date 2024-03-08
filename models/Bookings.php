<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings".
 *
 * @property int $id
 * @property string $booking_type
 * @property int $fk_customer
 * @property int $fk_booking_status
 * @property string $schedule_time
 * @property string $remarks
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $updated_by
 * @property string|null $updated_time
 *
 * @property BookingsServices[] $bookings   Services
 * @property BookingsTiming[] $bookingsTimings
 * @property BookingsStatus $fkBookingStatus
 * @property Customers $fkCustomer
 * @property Payments[] $payments
 */
class Bookings extends \yii\db\ActiveRecord
{
    public $searchQuery;
    public $select_Employee;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['booking_type', 'fk_customer', 'fk_booking_status', 'schedule_time', 'logged_by', 'logged_time'], 'required'],
            [['booking_type', 'remarks'], 'string'],
            [['fk_customer', 'fk_booking_status', 'select_Employee'], 'integer'],
            [['schedule_time', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'string', 'max' => 255],
            [['fk_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['fk_customer' => 'id']],
            [['fk_booking_status'], 'exist', 'skipOnError' => true, 'targetClass' => BookingsStatus::class, 'targetAttribute' => ['fk_booking_status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_type' => 'Booking Type',
            'fk_customer' => 'Fk Customer',
            'fk_booking_status' => 'Fk Booking Status',
            'schedule_time' => 'Schedule Time',
            'remarks' => 'Remarks',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * Gets query for [[BookingsServices]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsServicesQuery
     */
    public function getBookingsServices()
    {
        return $this->hasMany(BookingsServices::class, ['fk_booking' => 'id']);
    }

    /**
     * Gets query for [[BookingsTimings]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsTimingQuery
     */
    public function getBookingsTimings()
    {
        return $this->hasMany(BookingsTiming::class, ['fk_booking' => 'id']);
    }

    /**
     * Gets query for [[FkBookingStatus]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsStatusQuery
     */
    public function getFkBookingStatus()
    {
        return $this->hasOne(BookingsStatus::class, ['id' => 'fk_booking_status']);
    }

    /**
     * Gets query for [[FkCustomer]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CustomersQuery
     */
    public function getFkCustomer()
    {
        return $this->hasOne(Customers::class, ['id' => 'fk_customer']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PaymentsQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payments::class, ['fk_booking' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\BookingsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BookingsQuery(get_called_class());
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }
}
