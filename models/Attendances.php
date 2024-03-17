<?php

namespace app\models;

/**
 * This is the model class for table "attendances".
 *
 * @property int $id
 * @property int $fk_employee
 * @property string $date
 * @property string $sign_in
 * @property string|null $sign_out
 * @property string|null $remarks
 * @property string $sign_in_log
 * @property string|null $sign_out_log
 *
 * @property Employees $fkEmployee
 * @property Overtimes[] $overtimes
 * @property Undertimes[] $undertimes
 */
class Attendances extends \yii\db\ActiveRecord
{
    public $fk_employee_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_employee', 'sign_in', 'sign_in_log'], 'required'],
            [['fk_employee'], 'integer'],
            [['remarks', 'fk_employee_id'], 'string'],
            [['sign_in', 'sign_out', 'date'], 'string', 'max' => 100],
            [['sign_in_log', 'sign_out_log'], 'string', 'max' => 50],
            [['fk_employee'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::class, 'targetAttribute' => ['fk_employee' => 'id']],
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
            'sign_in' => 'Sign In',
            'sign_out' => 'Sign Out',
            'remarks' => 'Remarks',
            'sign_in_log' => 'Sign In Log',
            'sign_out_log' => 'Sign Out Log',
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
     * Gets query for [[Overtimes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\OvertimesQuery
     */
    public function getOvertimes()
    {
        return $this->hasMany(Overtimes::class, ['fk_attendance' => 'id']);
    }

    /**
     * Gets query for [[Undertimes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UndertimesQuery
     */
    public function getUndertimes()
    {
        return $this->hasMany(Undertimes::class, ['fk_attendance' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AttendancesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AttendancesQuery(get_called_class());
    }
}
