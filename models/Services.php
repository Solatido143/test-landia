<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $service_name
 * @property float $service_fee
 * @property int $completion_time
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $updated_by
 * @property string|null $updated_time
 *
 * @property BookingsServices[] $bookingsServices
 * @property EmployeesServices[] $employeesServices
 * @property ServicesFeesChanges[] $servicesFeesChanges
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_name', 'service_fee', 'completion_time', 'logged_by', 'logged_time'], 'required'],
            [['service_fee'], 'number', 'min' => 0],
            [['completion_time'], 'integer', 'min' => 30],
            [['service_name', 'logged_by', 'logged_time', 'updated_by', 'updated_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_name' => 'Service Name',
            'service_fee' => 'Service Fee',
            'completion_time' => 'Completion Time',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * Gets query for [[BookingsServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookingsServices()
    {
        return $this->hasMany(BookingsServices::class, ['fk_service' => 'id']);
    }

    /**
     * Gets query for [[EmployeesServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeesServices()
    {
        return $this->hasMany(EmployeesServices::class, ['fk_service' => 'id']);
    }

    /**
     * Gets query for [[ServicesFeesChanges]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServicesFeesChanges()
    {
        return $this->hasMany(ServicesFeesChanges::class, ['fk_service' => 'id']);
    }
}
