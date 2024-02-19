<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property int $fk_province
 * @property string $city
 *
 * @property Employees[] $employees
 * @property Provinces $fkProvince
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_province', 'city'], 'required'],
            [['fk_province'], 'integer'],
            [['city'], 'string', 'max' => 255],
            [['fk_province'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::class, 'targetAttribute' => ['fk_province' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_province' => 'Fk Province',
            'city' => 'City',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['fk_city' => 'id']);
    }

    /**
     * Gets query for [[FkProvince]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProvincesQuery
     */
    public function getFkProvince()
    {
        return $this->hasOne(Provinces::class, ['id' => 'fk_province']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\CitiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CitiesQuery(get_called_class());
    }
}
