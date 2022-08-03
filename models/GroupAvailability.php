<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group_availability".
 *
 * @property int $id
 * @property int $product_id
 * @property int $group_id
 * @property float $price
 * @property int $count
 * @property string|null $url
 */
class GroupAvailability extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_availability';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'group_id', 'price', 'count'], 'required'],
            [['product_id', 'group_id', 'count'], 'integer'],
            [['price'], 'number'],
            [['url'], 'string', 'max' => 255],
        ];
    }


    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(CompanyGroup::className(), ['id' => 'group_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'group_id' => 'Группа',
            'company_id' => 'Аптека',
            'price' => 'Цена',
            'url' => 'Ссылка',
            'count' => 'Количество',
        ];
    }
}
