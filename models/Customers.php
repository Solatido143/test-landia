<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $customer_name
 * @property string|null $contact_number
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $updated_by
 * @property string|null $updated_time
 *
 * @property Bookings[] $bookings
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_name', 'logged_by', 'logged_time'], 'required'],
            [['customer_name', 'contact_number', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_name' => 'Customer Name',
            'contact_number' => 'Contact Number',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\BookingsQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Bookings::class, ['fk_customer' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CustomersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CustomersQuery(get_called_class());
    }
}
