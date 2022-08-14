<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Category;
use yii\helpers\Url;

class categoryWidget extends Widget {

    public function init()
    {
        parent::init();
    }

    public function run()
    {
		$menu = '';
		$menu_query = Category::find()->where(["active" => 1, "parent_id" => 0])->all();
		foreach ($menu_query as $item) {
            $menu .= '<li><a onClick="openSubMenu(' . $item->id . ')" href="#">' . $item->name . '</a></li>';
		}

        return $menu;
    }
}
