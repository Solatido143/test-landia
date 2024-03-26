<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_products".
 *
 * @property int $id
 * @property int $product_id
 * @property string $sub_products_name
 * @property string $description
 * @property int $quantity
 *
 * @property InventoryUpdates[] $inventoryUpdates
 * @property Products $product
 */
class SubProducts extends \yii\db\ActiveRecord
{
    public $fk_item_status;
    public $new_stock_quantity;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'sub_products_name', 'description', 'quantity'], 'required'],
            [['product_id', 'fk_item_status', 'new_stock_quantity'], 'integer'],
            [['quantity'], 'integer', 'min' => 0],
            [['sub_products_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'sub_products_name' => 'Sub Products Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[InventoryUpdates]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\InventoryUpdatesQuery
     */
    public function getInventoryUpdates()
    {
        return $this->hasMany(InventoryUpdates::class, ['fk_id_sub_item_name' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProductsQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\SubProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\SubProductsQuery(get_called_class());
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }
}
