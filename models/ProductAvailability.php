<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_availability".
 *
 * @property int $id
 * @property int $product_id
 * @property int $company_id
 * @property float $price
 * @property int $count
 */
class ProductAvailability extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_availability';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'company_id', 'price', 'count'], 'required'],
            [['product_id', 'company_id', 'count'], 'integer'],
            ['url', 'url'],
            [['price'], 'number'],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'company_id' => 'Аптека',
            'price' => 'Цена',
            'url' => 'Ссылка',
            'count' => 'Количество',
        ];
    }
}
