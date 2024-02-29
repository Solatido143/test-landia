<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "undertimes_status".
 *
 * @property int $id
 * @property string|null $overtime_status
 * @property int|null $availability
 */
class UndertimesStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'undertimes_status';
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
     * {@inheritdoc}
     * @return \app\models\query\UndertimesStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UndertimesStatusQuery(get_called_class());
    }
}
