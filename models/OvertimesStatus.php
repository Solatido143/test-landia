<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "overtimes_status".
 *
 * @property int $id
 * @property string|null $overtime_status
 * @property int|null $availability
 *
 * @property Overtimes[] $overtimes
 */
class OvertimesStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'overtimes_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['availability'], 'integer'],
            [['overtime_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'overtime_status' => 'Overtime Status',
            'availability' => 'Availability',
        ];
    }

    /**
     * Gets query for [[Overtimes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\OvertimesQuery
     */
    public function getOvertimes()
    {
        return $this->hasMany(Overtimes::class, ['fk_overtime_status' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\OvertimesStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\OvertimesStatusQuery(get_called_class());
    }
}
