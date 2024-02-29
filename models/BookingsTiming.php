<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings_timing".
 *
 * @property int $id
 * @property int $fk_booking
 * @property string $booking_time
 * @property string|null $ongoing_time
 * @property string|null $completion_time
 *
 * @property Bookings $fkBooking
 */
class BookingsTiming extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings_timing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_booking', 'booking_time'], 'required'],
            [['fk_booking'], 'integer'],
            [['booking_time', 'ongoing_time', 'completion_time'], 'string', 'max' => 255],
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
            'booking_time' => 'Booking Time',
            'ongoing_time' => 'Ongoing Time',
            'completion_time' => 'Completion Time',
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
     * @return \app\models\query\BookingsTimingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BookingsTimingQuery(get_called_class());
    }
}