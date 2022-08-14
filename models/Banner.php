<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property int $active
 * @property string $url
 */
class Banner extends \yii\db\ActiveRecord
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
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active'], 'integer'],
            [['url'], 'required'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['url', 'url'],
            [['url'], 'string', 'max' => 255],
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
            'image' => 'Баннер',
            'url' => 'Ссылка',
        ];
    }

  	public function upload(){
  			$path = 'uploads/' . $this->image->baseName . '.' . $this->image->extension;
  			$this->image->saveAs($path);
  			$this->attachImage($path);
  			@unlink($path);
  	}
}
