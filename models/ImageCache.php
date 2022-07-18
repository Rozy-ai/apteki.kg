<?php

namespace app\models;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "image_cache".
 *
 * @property int $id
 * @property string $hash
 * @property string $path
 * @property int $sort
 */
class ImageCache extends \yii\db\ActiveRecord
{

    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_cache';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['hash', 'path', 'sort'], 'required'],
            [['hash', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'path' => 'Path',
            'sort' => 'Sort',
        ];
    }

    public function upload(){
        if(!$this->image->saveAs($this->path)) return false;
        return true;
    }
}
