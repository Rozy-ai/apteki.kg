<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property int $description
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'meta_description', 'meta_keywords', 'description'], 'required'],
            [['description'], 'string'],
            [['title', 'meta_description', 'meta_keywords'], 'string', 'max' => 255],
        ];
    }
	
	
    public function getUrl()
	{
		$name = (string) $this->title; // преобразуем в строковое значение
		$name = strip_tags($name); // убираем HTML-теги
		$name = str_replace(array("\n", "\r"), " ", $name); // убираем перевод каретки
		$name = preg_replace("/\s+/", ' ', $name); // удаляем повторяющие пробелы
		$name = trim($name); // убираем пробелы в начале и конце строки
		$name = function_exists('mb_strtolower') ? mb_strtolower($name) : strtolower($name); // переводим строку в нижний регистр (иногда надо задать локаль)
		$name = strtr($name, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
		$name = preg_replace("/[^0-9a-z-_ ]/i", "", $name); // очищаем строку от недопустимых символов
		$name = str_replace(" ", "-", $name); // заменяем пробелы знаком минус
		return Url::to(['/page/index', 'name' => $this->id . '-' . $name], 'https');; // возвращаем результат
	}
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'meta_description' => 'Мета описание',
            'meta_keywords' => 'Мета теги',
            'description' => 'Содержимое страницы',
        ];
    }
}
