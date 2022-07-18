<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parser_category".
 *
 * @property int $id
 * @property string $name
 * @property int $refers_id
 * @property int $parent_id
 * @property string|null $url
 * @property int $type
 * @property int $date
 */
class ParserCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'date'], 'required'],
            [['refers_id', 'parent_id', 'type', 'date', 'status'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    public function getParent()
    {
        return $this->hasOne(ParserCategory::className(), ['id' => 'parent_id']);
    }

    public function getRefers()
    {
        return $this->hasOne(Category::className(), ['id' => 'refers_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'refers_id' => 'Связь',
            'parent_id' => 'Родительская категория',
            'url' => 'Ссылка',
            'type' => 'Тип парсера',
            'date' => 'Дата',
            'status' => 'Статус'
        ];
    }
}
