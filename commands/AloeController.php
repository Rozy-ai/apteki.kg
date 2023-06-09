<?php

namespace app\commands;

use Yii;
use app\models\Product;
use app\models\ProductAvailability;
use app\models\Category;
use app\models\Country;
use app\models\Producer;
use app\models\ParserCategory;
use app\models\ParserProduct;
use simplehtmldom\HtmlDocument;
use yii\console\ExitCode;

class AloeController extends BaseController
{
    public function actionParser() {

      $parser_type = 2;

      if($this->checkProcess($this->route)) {
        return ExitCode::OK;
      }

      $settings = $this->getSettings($parser_type);
      if(!$settings) {
        return ExitCode::OK;
      }

      if($settings->category_status == 1) {
        $this->parserCategory();
        $settings->category_status = 0;
        $settings->save();
      } else if($settings->products_status == 1) {
        $this->parserProducts();
        $settings->products_status = 0;
        $settings->save();
      } else if($settings->product_status == 1) {
        $this->parserProduct();
        $settings->product_status = 0;
        $settings->save();
      }
    }

    protected function parserCategory()
    {
        set_time_limit(0);

        $parser_type = 2;
        $date = time();
        $url_site = 'http://aloe.kg';
        $ch = curl_init();

    		curl_setopt($ch, CURLOPT_URL, $url_site . "/catalog.html");
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    		$doc = curl_exec($ch);

    		curl_close($ch);

        $htmlDoc = new HtmlDocument($doc);

        foreach ($htmlDoc->find('.menu .item1') as $item) {
          $elemDoc = $item->find("a", 0);
          $name = strip_tags($elemDoc->innertext);
          $name = trim(preg_replace("/\\(.+\\)/m","",$name));

          $url = $elemDoc->getAttribute("href");
          if($url == null || $url == "/" || $url == "" || $url == "#") {
            $url = null;
          } else if(strpos($url, $url_site) === false) {
            $url = $url_site . $url;
          }

          $main_category = ParserCategory::findOne(["parent_id" => 0, "type" => $parser_type, "name" => $name, "url" => $url]);
          if(!$main_category) {
            $main_category = new ParserCategory(["parent_id" => 0, "type" => $parser_type, "name" => $name, "url" => $url]);
          }
          $main_category->date = $date;
          $main_category->save();

          foreach ($item->find('.item2 a') as $subitem) {
            $name = strip_tags($subitem->innertext);
            $name = trim(preg_replace("/\\(.+\\)/m","",$name));

            $url = $subitem->getAttribute("href");
            if($url == null || $url == "/" || $url == "" || $url == "#") {
              $url = null;
            } else if(strpos($url, $url_site) === false) {
              $url = $url_site . $url;
            }

            $sub_category = ParserCategory::findOne(["parent_id" => $main_category->id, "type" => $parser_type, "name" => $name, "url" => $url]);
            if(!$sub_category) {
              $sub_category = new ParserCategory(["parent_id" => $main_category->id, "type" => $parser_type, "name" => $name, "url" => $url]);
            }
            $sub_category->date = $date;
            $sub_category->save();
          }
        }
    }

    protected function parserProducts()
    {
        set_time_limit(0);

        $parser_type = 2;
        $url_site = 'http://aloe.kg';
        $date = time();

        $categorys = ParserCategory::find()->where(["type" => $parser_type, "status" => 0])->andWhere(["<>", "refers_id", 0])->all();
        foreach ($categorys as $category) {

          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, $category->url . "?limit=1000");
          curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      		$doc = curl_exec($ch);

          curl_close($ch);

          $htmlDoc = new HtmlDocument($doc);

          foreach ($htmlDoc->find('.product .name a') as $item) {
              $name = strip_tags($item->outertext);
              $url = $item->getAttribute("href");
              if($url == null || $url == "/" || $url == "" || $url == "#") {
                $url = null;
              } else if(strpos($url, $url_site) === false) {
                $url = $url_site . $url;
              }

              $product = ParserProduct::findOne(["parser_category_id" => $category->id, "type" => $parser_type, "name" => $name, "url" => $url]);
              if(!$product) {
                $product = new ParserProduct(["parser_category_id" => $category->id, "type" => $parser_type, "name" => $name, "url" => $url]);
              }
              $product->date = $date;
              $product->save();
          }

          $category->status = 1;
          $category->save();

          sleep(1);
      }
    }

    protected function parserProduct()
    {
        set_time_limit(0);

        $company_id = 2;
        $parser_type = 2;
        $date = time();

        $products = ParserProduct::find()->where(["type" => $parser_type, "status" => 0])->all();

        foreach ($products as $product) {

          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, $product->url);
          curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

      		$doc = curl_exec($ch);

          curl_close($ch);

          $htmlDoc = new HtmlDocument($doc);

          $item = Product::findOne(["parser_product_id" => $product->id, "name" => $product->name]);
          if(!$item) {
            $item = new Product(["parser_product_id" => $product->id, "name" => $product->name]);

            $item->category_id = isset($product->parserCategory) ? $product->parserCategory->refers_id : 0;


            $item->number = 0;
            $codeElem = $htmlDoc->find("#product_code", 0);
            if($codeElem) {
              $item->number = preg_replace('/[^0-9]/', '', $codeElem->outertext);
              if($item->number == null) $item->number = 0;
            }

            $item->price = 0;
            $priceElem = $htmlDoc->find("#block_price", 0);
            if($priceElem) {
              $item->price = preg_replace('/[^0-9]/', '', $priceElem->outertext);
              //echo "price: " . $item->price . "\n";
            }

            $item->description = null;
            $descriptionElem = $htmlDoc->find(".jshop_prod_description", 0);
            if($descriptionElem) {
              $item->description = $descriptionElem->outertext;
            }

            $item->save();

            $imagesElem = $htmlDoc->find("#list_product_image_middle a");
            foreach ($imagesElem as $image) {
                $url = $image->getAttribute("href");
                $array = explode(".", $url);
                $expansion = $array[count($array) - 1];
                $path = Yii::getAlias('@app') . "/web/uploads/aloe_" . time() . "." .  $expansion;
                try {
                    file_put_contents($path , fopen($url, 'r'));
                    $item->attachImage($path);
                    unlink($path);
                } catch (\Exception $e) {
                    $this->consoleLog($parser_type, $e->getMessage());
                }
                sleep(1);
            }

            $availability = new ProductAvailability(["product_id" => $item->id, "company_id" => $company_id, "price" => $item->price, "count" => 0, "url" => $product->url]);
            $availability->save();
          }

          $product->status = 1;
          $product->save();

          sleep(1);
        }
    }
}
