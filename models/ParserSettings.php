<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_settings".
 *
 * @property int $id
 * @property int $category_status
 * @property int $products_status
 * @property int $product_status
 */
class ParserSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_status', 'products_status', 'product_status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_status' => 'Category Status',
            'products_status' => 'Products Status',
            'product_status' => 'Product Status',
        ];
    }
}
