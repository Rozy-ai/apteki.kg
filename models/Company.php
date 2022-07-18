<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property int $active
 * @property string $name
 * @property int $type
 * @property int $address
 * @property float $lat
 * @property float $lon
 * @property string $site
 */
class Company extends \yii\db\ActiveRecord
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
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['active', 'type', 'user_id'], 'integer'],
            [['name', 'type'], 'required'],
            [['lat', 'lon'], 'number'],
						[['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['site'], 'required', 'when' => function ($model) {
						    if($model->type == 2) {
									return true;
								}
						    return false;
					    }, 'whenClient' => "function (attribute, value) { return $('#company-type').val() == 2; }", 'message' => 'Необходимо заполнить "Сайт"'],
            ['site', 'url'],
            [['address'], 'required', 'when' => function ($model) {
                if($model->type != 2) {
                  return true;
                }
                return false;
              }, 'whenClient' => "function (attribute, value) { return $('#company-type').val() != 2; }", 'message' => 'Необходимо заполнить "Адрес"'],
            ['site', 'url'],
            [['name', 'site', 'address', 'work', 'contact'], 'string', 'max' => 255],
            ['description', 'string'],
            [['rating'], 'number'],
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
            'user_id' => 'Владелец',
            'name' => 'Название',
            'type' => 'Тип',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'lon' => 'Долгота',
            'site' => 'Сайт',
            'rating' => 'Рейтинг',
            'image' => 'Логотип',
            'contact' => 'Контакты',
            'work' => 'Режим работы'
        ];
    }

  	public function upload(){
  			$path = 'uploads/' . $this->image->baseName . '.' . $this->image->extension;
  			$this->image->saveAs($path);
  			$this->attachImage($path);
  			@unlink($path);
  	}
}
