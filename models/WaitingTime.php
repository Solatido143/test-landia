<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "waiting_time".
 *
 * @property string $employee_name
 * @property string|null $min(bt.ongoing_time)
 * @property float|null $waiting_time
 */
class WaitingTime extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'waiting_time';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['waiting_time'], 'number'],
            [['employee_name'], 'string', 'max' => 101],
            [['min(bt.ongoing_time)'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_name' => 'Employee Name',
            'min(bt.ongoing_time)' => 'Min(bt Ongoing Time)',
            'waiting_time' => 'Waiting Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\WaitingTimeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\WaitingTimeQuery(get_called_class());
    }
}
