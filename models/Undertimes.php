<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "undertimes".
 *
 * @property int $id
 * @property int $fk_attendance
 * @property int $fk_undertime_status
 * @property string $undertime_start
 * @property string $undertime_end
 * @property string|null $undertime_remarks
 * @property string|null $approved_start
 * @property string|null $approved_end
 * @property string|null $approval_remarks
 * @property string $logged_by
 * @property string $logged_time
 * @property string|null $approved_by
 * @property string|null $approved_time
 *
 * @property Attendances $fkAttendance
 * @property Undertimes $fkUndertimeStatus
 * @property Undertimes[] $undertimes
 */
class Undertimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'undertimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_attendance', 'fk_undertime_status', 'undertime_start', 'undertime_end', 'logged_by', 'logged_time'], 'required'],
            [['fk_attendance', 'fk_undertime_status'], 'integer'],
            [['undertime_start', 'undertime_end', 'undertime_remarks', 'approved_start', 'approved_end', 'approval_remarks', 'logged_by', 'logged_time', 'approved_by', 'approved_time'], 'string', 'max' => 255],
            [['fk_attendance'], 'exist', 'skipOnError' => true, 'targetClass' => Attendances::class, 'targetAttribute' => ['fk_attendance' => 'id']],
            [['fk_undertime_status'], 'exist', 'skipOnError' => true, 'targetClass' => Undertimes::class, 'targetAttribute' => ['fk_undertime_status' => 'id']],
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
            'fk_undertime_status' => 'Fk Undertime Status',
            'undertime_start' => 'Undertime Start',
            'undertime_end' => 'Undertime End',
            'undertime_remarks' => 'Undertime Remarks',
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
     * Gets query for [[FkUndertimeStatus]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UndertimesQuery
     */
    public function getFkUndertimeStatus()
    {
        return $this->hasOne(Undertimes::class, ['id' => 'fk_undertime_status']);
    }

    /**
     * Gets query for [[Undertimes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UndertimesQuery
     */
    public function getUndertimes()
    {
        return $this->hasMany(Undertimes::class, ['fk_undertime_status' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UndertimesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UndertimesQuery(get_called_class());
    }
}
