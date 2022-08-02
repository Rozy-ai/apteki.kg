<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AvailabilityForm extends Model
{

    public $price;
    public $count;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'count'], 'required'],
            ['price', 'each', 'rule' => ['number', 'min' => 0]],
            ['count', 'each', 'rule' => ['integer', 'min' => 0]],
        ];
    }


	public function attributeLabels()
    {
        return [
            'price' => 'Цена',
            'count' => 'Количество',
		];
	}
}
