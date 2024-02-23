<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sub_products".
 *
 * @property int $id
 * @property int $sub_product_id
 * @property string $name
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
            [['sub_product_id', 'name', 'description', 'quantity'], 'required'],
            [['sub_product_id', 'quantity'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['sub_product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['sub_product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sub_product_id' => 'Sub Product ID',
            'name' => 'Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[SubProduct]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ProductsQuery
     */
    public function getSubProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'sub_product_id']);
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
