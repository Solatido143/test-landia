<?php

namespace app\models;

/**
 * This is the model class for table "employees_services".
 *
 * @property int $id
 * @property int $fk_employee
 * @property int $fk_service
 * @property string $logged_by
 * @property string $logged_time
 *
 * @property Employees $fkEmployee
 * @property Services $fkService
 */
class EmployeesServices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_employee', 'fk_service', 'logged_by', 'logged_time'], 'required'],
            [['fk_employee', 'fk_service'], 'integer'],
            [['logged_by', 'logged_time'], 'string', 'max' => 255],
            [['fk_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::class, 'targetAttribute' => ['fk_employee' => 'id']],
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
            'fk_employee' => 'Fk Employee',
            'fk_service' => 'Fk Service',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
        ];
    }

    /**
     * Gets query for [[FkEmployee]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getFkEmployee()
    {
        return $this->hasOne(Employees::class, ['id' => 'fk_employee']);
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
     * @return \app\models\query\EmployeesServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EmployeesServicesQuery(get_called_class());
    }
}
