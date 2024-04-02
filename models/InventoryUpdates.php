<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inventory_updates".
 *
 * @property int $id
 * @property int $fk_id_item
 * @property int $fk_id_sub_item
 * @property int $fk_item_status
 * @property int $quantity
 * @property string|null $updated_by
 * @property string|null $updated_time
 *
 * @property Products $fkIdItemName
 * @property SubProducts $fkIdSubItemName
 * @property InventoryStatus $fkItemStatus
 */
class InventoryUpdates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inventory_updates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_id_item', 'fk_id_sub_item', 'fk_item_status', 'quantity'], 'integer'],
            [['quantity'], 'integer', 'min' => 0],
            [['updated_by', 'updated_time'], 'string', 'max' => 255],
            [['fk_id_item'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['fk_id_item' => 'id']],
            [['fk_id_sub_item'], 'exist', 'skipOnError' => true, 'targetClass' => SubProducts::class, 'targetAttribute' => ['fk_id_sub_item' => 'id']],
            [['fk_item_status'], 'exist', 'skipOnError' => true, 'targetClass' => InventoryStatus::class, 'targetAttribute' => ['fk_item_status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fk_id_item' => 'Item Name',
            'fk_id_sub_item' => 'Sub Item Name',
            'fk_item_status' => 'Status',
            'quantity' => 'Quantity',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }

    /**
     * Gets query for [[FkIdItemName]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProductsQuery
     */
    public function getFkIdItemName()
    {
        return $this->hasOne(Products::class, ['id' => 'fk_id_item']);
    }

    /**
     * Gets query for [[FkIdSubItemName]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\SubProductsQuery
     */
    public function getFkIdSubItemName()
    {
        return $this->hasOne(SubProducts::class, ['id' => 'fk_id_sub_item']);
    }

    /**
     * Gets query for [[FkItemStatus]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\InventoryStatusQuery
     */
    public function getFkItemStatus()
    {
        return $this->hasOne(InventoryStatus::class, ['id' => 'fk_item_status']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\InventoryUpdatesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\InventoryUpdatesQuery(get_called_class());
    }
}
