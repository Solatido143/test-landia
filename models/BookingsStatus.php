<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings_status".
 *
 * @property int $id
 * @property string $booking_status
 *
 * @property Bookings[] $bookings
 */
class BookingsStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['booking_status'], 'required'],
            [['booking_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booking_status' => 'Booking Status',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Bookings::class, ['fk_booking_status' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\BookingsStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BookingsStatusQuery(get_called_class());
    }
}
