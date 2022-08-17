<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Menu;

class menuWidget extends Widget {

    public $style = 0;
    public $type;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
		$menu = '';
		$menu_query = Menu::find()->where(["type" => $this->type])->orderBy('priority,id')->all();
		foreach ($menu_query as $item) {
            if($this->style == 1) {
                $menu .= '<div class="col-6"><div class="navbar-menu-item"><a href="' . $item->url . '">' . $item->title . '</a></div></div>';
            } else {
			    $menu .= '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
            }
		}
		
        return $menu;
    }
}