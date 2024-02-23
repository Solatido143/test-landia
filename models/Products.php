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
 */
class Products extends \yii\db\ActiveRecord
{
    public $color;
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
            [['name', 'description', 'price', 'stock_quantity'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['stock_quantity'], 'integer'],
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
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProductsQuery(get_called_class());
    }
}
