<?php

namespace app\models;

/**
 * This is the model class for table "positions".
 *
 * @property int $id
 * @property string $position
 * @property int $availability
 *
 * @property Employees[] $employees
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position'], 'required'],
            [['availability'], 'integer'],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'availability' => 'Availability',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['fk_position' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PositionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PositionsQuery(get_called_class());
    }
}
