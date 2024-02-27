<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $stock_quantity
 * @property int $isRemove
 *
 * @property SubProducts[] $sub-products
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
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string'],
            [['stock_quantity', 'isRemove'], 'integer'],
            ['stock_quantity', 'integer', 'min' => 0], // Ensure stock_quantity is an integer with a minimum value of 0
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
        return $this->hasMany(SubProducts::class, ['product_id' => 'id']);
    }
}
