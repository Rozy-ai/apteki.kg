<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_analog".
 *
 * @property int $id
 * @property int $product_id
 * @property int $analog_id
 */
class ProductAnalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_analog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'analog_id'], 'required'],
            [['product_id', 'analog_id'], 'integer'],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getAnalog()
    {
        return $this->hasOne(Product::className(), ['id' => 'analog_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'analog_id' => 'Аналог товара',
        ];
    }
}
