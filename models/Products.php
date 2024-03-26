<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $product_name
 * @property string $description
 * @property int|null $stock_quantity
 *
 * @property InventoryUpdates[] $inventoryUpdates
 * @property SubProducts[] $subProducts
 */
class Products extends \yii\db\ActiveRecord
{
    public $new_stock_quantity;
    public $fk_item_status;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_name', 'description'], 'required'],
            [['description'], 'string'],
            [['fk_item_status'], 'integer'],
            [['stock_quantity', 'new_stock_quantity'], 'integer', 'min' => 0],
            [['product_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'stock_quantity' => 'Stock Quantity',
        ];
    }

    /**
     * Gets query for [[InventoryUpdates]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\InventoryUpdatesQuery
     */
    public function getInventoryUpdates()
    {
        return $this->hasMany(InventoryUpdates::class, ['fk_id_item_name' => 'id']);
    }

    /**
     * Gets query for [[SubProducts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\SubProductsQuery
     */
    public function getSubProducts()
    {
        return $this->hasMany(SubProducts::class, ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProductsQuery(get_called_class());
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }
}
