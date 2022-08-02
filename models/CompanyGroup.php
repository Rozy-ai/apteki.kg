<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company_group".
 *
 * @property int $id
 * @property int $active
 * @property string $name
 */
class CompanyGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
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
        ];
    }
}
