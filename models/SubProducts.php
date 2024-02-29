<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_products".
 *
 * @property int $id
 * @property int $product_id
 * @property string sub_products_name
 * @property string $description
 * @property int $quantity
 *
 * @property Products $subProduct
 */
class SubProducts extends \yii\db\ActiveRecord
{
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
            [['product_id', 'quantity'], 'integer'],
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
            'product_id' => 'Sub Product ID',
            'sub_products_name' => 'Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[SubProduct]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProductsQuery
     */
    public function getProducts()
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
}
