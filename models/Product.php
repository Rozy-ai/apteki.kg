<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $active
 * @property int $name
 * @property int $price
 * @property int $number
 * @property float $rating
 * @property int $category_id
 * @property int $producer_id
 * @property int $substance_id
 * @property int $country_id
 */
class Product extends \yii\db\ActiveRecord
{

  	public $hash;

    public function behaviors()
    {
        return [
            'images' => [
                'class' => 'app\modules\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'availability_count', 'number', 'category_id', 'producer_id', 'substance_id', 'country_id', 'parser_product_id'], 'integer'],
            [['name', 'category_id'], 'required'],
            ['price', 'number'],
            ["description", "string"],
            [['name', 'hash'], 'string', 'max' => 255],
            [['rating'], 'number'],
        ];
    }

    public function getFavorite()
    {
        return $this->hasOne(ProductFavorite::className(), ['product_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getProducer()
    {
        return $this->hasOne(Producer::className(), ['id' => 'producer_id']);
    }

    public function getAnalog()
    {
        return $this->hasOne(ProductAnalog::className(), ['analog_id' => 'id']);
    }

    public function getGroupAvailability()
    {
        return $this->hasMany(GroupAvailability::className(), ['product_id' => 'id']);
    }

    public function getAvailability()
    {
        return $this->hasMany(ProductAvailability::className(), ['product_id' => 'id']);
    }

    public function getAvailabilityOne()
    {
        return $this->hasOne(ProductAvailability::className(), ['product_id' => 'id']);
    }

    public function getSubstance()
    {
        return $this->hasOne(Substance::className(), ['id' => 'substance_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Активность',
            'name' => 'Название',
            'price' => 'Цена',
            'availability_count' => 'Предложения',
            'number' => 'Артикул',
            'rating' => 'Рейтинг',
            'category_id' => 'Категория',
            'producer_id' => 'Производитель',
            'substance_id' => 'Действующее вещество',
            'country_id' => 'Страна',
            'description' => 'Описание',
            'parser_product_id' => "Парсер"
        ];
    }
}
