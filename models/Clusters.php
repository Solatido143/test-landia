<?php

namespace app\models;

/**
 * This is the model class for table "clusters".
 *
 * @property int $id
 * @property string $cluster
 *
 * @property Employees[] $employees
 * @property Regions[] $regions
 */
class Clusters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clusters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cluster'], 'required'],
            [['cluster'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cluster' => 'Cluster',
        ];
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\EmployeesQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::class, ['fk_cluster' => 'id']);
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\RegionsQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Regions::class, ['fk_cluster' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ClustersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ClustersQuery(get_called_class());
    }
}
