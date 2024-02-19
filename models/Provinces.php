<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "provinces".
 *
 * @property int $id
 * @property int $fk_region
 * @property string|null $province
 *
 * @property Cities[] $cities
 * @property Employees[] $employees
 * @property Regions $fkRegion
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provinces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_region'], 'required'],
            [['fk_region'], 'integer'],
            [['province'], 'string', 'max' => 255],
            [['fk_region'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['fk_region' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_region' => 'Fk Region',
            'province' => 'Province',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CitiesQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::class, ['fk_province' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['fk_region_area' => 'id']);
    }

    /**
     * Gets query for [[FkRegion]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\RegionsQuery
     */
    public function getFkRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'fk_region']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProvincesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProvincesQuery(get_called_class());
    }
}
