<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_product".
 *
 * @property int $id
 * @property int $parser_category_id
 * @property int $type
 * @property string $name
 * @property string $url
 * @property int $status
 */
class ParserProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parser_category_id', 'type', 'name', 'url', 'date'], 'required'],
            [['parser_category_id', 'type', 'status', 'date'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    public function getParserCategory()
    {
        return $this->hasOne(ParserCategory::className(), ['id' => 'parser_category_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parser_category_id' => 'Категория',
            'type' => 'Тип',
            'name' => 'Название',
            'url' => 'Ссылка',
            'date' => 'Дата',
            'status' => 'Статус',
        ];
    }
}
