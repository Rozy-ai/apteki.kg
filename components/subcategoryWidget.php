<?php

namespace app\components;

use Yii;
use yii\base\Widget;
use app\models\Category;
use yii\helpers\Url;

class subcategoryWidget extends Widget {

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $menu = '';
        $menu_query = Category::find()->where(["active" => 1, "parent_id" => 0])->all();
        foreach ($menu_query as $item) {
            $menu .= '<div id="sub-' . $item->id . '" class="sub-category hide"><h5>' . $item->name . '</h5><div class="row">';
            $sub_menu_query = Category::find()->where(["active" => 1, "parent_id" => $item->id])->all();
            foreach ($sub_menu_query as $sub_item) {
                $menu .= '<div class="col-12 col-sm-6"><span>&bull;</span><a href="' . Url::to(['category/index', 'id' => $sub_item->id]) . '">' . $sub_item->name . '</a></div>';
            }
            $menu .= '</div></div>';
        }

        return $menu;
    }
}
