<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $active
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    public $image;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'app\modules\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'parent_id'], 'integer'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
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
            'image' => 'Подложка',
            'name' => 'Название',
        ];
    }

    public function upload(){
        $path = 'uploads/' . $this->image->baseName . '.' . $this->image->extension;
        $this->image->saveAs($path);
        $this->attachImage($path);
        @unlink($path);
    }
}
