<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "overtimes".
 *
 * @property int $id
 * @property int $fk_attendance
 * @property int $fk_overtime_status
 * @property string $overtime_start
 * @property string $overtime_end
 * @property string|null $overtime_remarks
 * @property string|null $approved_start
 * @property string|null $approved_end
 * @property string|null $approval_remarks
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $approved_by
 * @property string|null $approved_time
 *
 * @property Attendances $fkAttendance
 * @property OvertimesStatus $fkOvertimeStatus
 */
class Overtimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'overtimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_attendance', 'fk_overtime_status', 'overtime_start', 'overtime_end', 'logged_by', 'logged_time'], 'required'],
            [['fk_attendance', 'fk_overtime_status'], 'integer'],
            [['overtime_start', 'overtime_end', 'overtime_remarks', 'approved_start', 'approved_end', 'approval_remarks', 'logged_by', 'logged_time', 'approved_by', 'approved_time'], 'string', 'max' => 255],
            [['fk_attendance'], 'exist', 'skipOnError' => true, 'targetClass' => Attendances::class, 'targetAttribute' => ['fk_attendance' => 'id']],
            [['fk_overtime_status'], 'exist', 'skipOnError' => true, 'targetClass' => OvertimesStatus::class, 'targetAttribute' => ['fk_overtime_status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_attendance' => 'Fk Attendance',
            'fk_overtime_status' => 'Fk Overtime Status',
            'overtime_start' => 'Overtime Start',
            'overtime_end' => 'Overtime End',
            'overtime_remarks' => 'Overtime Remarks',
            'approved_start' => 'Approved Start',
            'approved_end' => 'Approved End',
            'approval_remarks' => 'Approval Remarks',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
            'approved_by' => 'Approved By',
            'approved_time' => 'Approved Time',
        ];
    }

    /**
     * Gets query for [[FkAttendance]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\AttendancesQuery
     */
    public function getFkAttendance()
    {
        return $this->hasOne(Attendances::class, ['id' => 'fk_attendance']);
    }

    /**
     * Gets query for [[FkOvertimeStatus]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\OvertimesStatusQuery
     */
    public function getFkOvertimeStatus()
    {
        return $this->hasOne(OvertimesStatus::class, ['id' => 'fk_overtime_status']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\OvertimesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OvertimesQuery(get_called_class());
    }
}
