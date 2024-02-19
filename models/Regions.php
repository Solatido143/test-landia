<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property int $fk_cluster
 * @property string $region
 * @property string|null $description
 *
 * @property Employees[] $employees
 * @property Clusters $fkCluster
 * @property Provinces[] $provinces
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_cluster', 'region'], 'required'],
            [['fk_cluster'], 'integer'],
            [['region', 'description'], 'string', 'max' => 255],
            [['fk_cluster'], 'exist', 'skipOnError' => true, 'targetClass' => Clusters::class, 'targetAttribute' => ['fk_cluster' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_cluster' => 'Fk Cluster',
            'region' => 'Region',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['fk_region' => 'id']);
    }

    /**
     * Gets query for [[FkCluster]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ClustersQuery
     */
    public function getFkCluster()
    {
        return $this->hasOne(Clusters::class, ['id' => 'fk_cluster']);
    }

    /**
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProvincesQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Provinces::class, ['fk_region' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\RegionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RegionsQuery(get_called_class());
    }
}
