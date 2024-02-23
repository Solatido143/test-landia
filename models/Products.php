<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $stock_quantity
 * @property int $isRemove
 *
 * @property SubProducts[] $subProducts
 */
class Products extends \yii\db\ActiveRecord
{
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
            [['name', 'description', 'price', 'stock_quantity', 'isRemove'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['stock_quantity', 'isRemove'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'stock_quantity' => 'Stock Quantity',
            'isRemove' => 'Is Remove',
        ];
    }

    /**
     * Gets query for [[SubProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubProducts()
    {
        return $this->hasMany(SubProducts::class, ['sub_product_id' => 'id']);
    }
}
