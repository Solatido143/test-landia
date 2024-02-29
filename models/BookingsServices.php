<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookings_services".
 *
 * @property int $id
 * @property int $fk_booking
 * @property int $fk_service
 *
 * @property Bookings $fkBooking
 * @property Services $fkService
 */
class BookingsServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookings_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_booking', 'fk_service'], 'required'],
            [['fk_booking', 'fk_service'], 'integer'],
            [['fk_booking'], 'exist', 'skipOnError' => true, 'targetClass' => Bookings::class, 'targetAttribute' => ['fk_booking' => 'id']],
            [['fk_service'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['fk_service' => 'id']],
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
            'fk_service' => 'Fk Service',
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
     * Gets query for [[FkService]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ServicesQuery
     */
    public function getFkService()
    {
        return $this->hasOne(Services::class, ['id' => 'fk_service']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\BookingsServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BookingsServicesQuery(get_called_class());
    }
}
