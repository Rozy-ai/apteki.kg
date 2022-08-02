<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $email
 * @property string $password
 * @property string|null $name
 * @property string|null $token
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name'], 'required'],
						[['image'], 'file', 'extensions' => 'png, jpg, jpeg'],
            ['email', 'unique'],
            [['email', 'password', 'token'], 'string', 'max' => 255],
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'image' => 'Аватар',
            'name' => 'Имя',
            'token' => 'Token',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->token === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

  	public function upload(){
  			$path = 'uploads/' . $this->image->baseName . '.' . $this->image->extension;
  			$this->image->saveAs($path);
  			$this->attachImage($path);
  			@unlink($path);
  	}
}
