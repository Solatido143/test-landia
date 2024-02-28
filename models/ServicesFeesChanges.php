<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services_fees_changes".
 *
 * @property int $id
 * @property int $fk_service
 * @property float $old_service_fee
 * @property float $new_service_fee
 * @property string $logged_by
 * @property string $logged_time
 *
 * @property Services $fkService
 */
class ServicesFeesChanges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services_fees_changes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_service', 'old_service_fee', 'new_service_fee', 'logged_by', 'logged_time'], 'required'],
            [['fk_service'], 'integer'],
            [['old_service_fee', 'new_service_fee'], 'number'],
            [['logged_by', 'logged_time'], 'string', 'max' => 255],
            [['fk_service'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['fk_service' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_service' => 'Fk Service',
            'old_service_fee' => 'Old Service Fee',
            'new_service_fee' => 'New Service Fee',
            'logged_by' => 'Logged By',
            'logged_time' => 'Logged Time',
        ];
    }

    /**
     * Gets query for [[FkService]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFkService()
    {
        return $this->hasOne(Services::class, ['id' => 'fk_service']);
    }
}
