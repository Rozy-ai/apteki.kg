<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property int $mail
 * @property int $name
 * @property int $phone
 * @property string $message
 * @property int $date
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail', 'name', 'phone', 'message', 'date'], 'required'],
            [['date'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['phone', 'match', 'pattern' => '/^\+7\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/', 'message' => 'Пример: +7(999) 999-99-99'],
            ['mail', 'email'],
            [['message'], 'string'],
        ];
    }

    public function afterFind()
    {
  		if($this->phone) $this->phone =  $this->maskPhone($this->phone);
    }

  	static function maskPhone($number) {
  		return sprintf("+%s(%s) %s-%s-%s",
  			substr($number, 0, 1),
  			substr($number, 1, 3),
  			substr($number, 4, 3),
  			substr($number, 7, 2),
  			substr($number, 9)
  		);
  	}

  	public function beforeSave($insert)
  	{
  		$this->phone = preg_replace('/[^0-9]/', '', $this->phone);

  		if (parent::beforeSave($insert)) {
  			return true;
  		} else {
  			return false;
  		}
  	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail' => 'E-mail',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'message' => 'Сообщение',
            'date' => 'Дата',
        ];
    }
}
