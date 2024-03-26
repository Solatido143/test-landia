<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_status".
 *
 * @property int $id
 * @property string $item_status
 *
 * @property InventoryUpdates[] $inventoryUpdates
 */
class InventoryStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_status'], 'required'],
            [['item_status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_status' => 'Item Status',
        ];
    }

    /**
     * Gets query for [[InventoryUpdates]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\InventoryUpdatesQuery
     */
    public function getInventoryUpdates()
    {
        return $this->hasMany(InventoryUpdates::class, ['fk_item_status' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\InventoryStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\InventoryStatusQuery(get_called_class());
    }
}
