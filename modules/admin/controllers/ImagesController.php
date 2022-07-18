<?php

namespace app\modules\api\controllers;

use Yii;
use yii\web\Controller;
use app\models\Articles;
use app\models\ImageCache;
use yii\web\UploadedFile;
use yii\helpers\Url;


class ImagesController extends Controller
{
    public function actionUpload()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) return ["error" => "Не авторизован"];

        $hash = Yii::$app->request->post('hash');
        $article_id = Yii::$app->request->post('article_id', 0);

        $imageSort = ImageCache::find()->where(["hash" => $hash])->orderBy("sort")->one();

        $model = new ImageCache();
        $model->hash = $hash;
        $model->sort = isset($imageSort) ? ($imageSort->sort + 1) : 0;
        $model->image = UploadedFile::getInstanceByName('image');
        $model->path = 'uploads/' . $model->hash . '-'. Yii::$app->security->generateRandomString(8) . '.' . $model->image->extension;

        if(!$model->save()) return ["error" => "Ошибка сохранения"];
        if(!$model->upload()) return ["error" => "Ошибка загрузки"];

        $initialPreview = array(Url::to("@web/" . $model->path));
        $initialPreviewConfig = array(["key" => $model->id, "caption" => "Фото " . $model->id]);

        if($article_id != 0) {
            $acticle = Articles::findOne($article_id);
            if(empty($acticle)) return ["error" => "Объявление не найдено"];
            $image = $acticle->attachImage($model->path);
            if($image) {
                unlink($model->path);
                $model->delete();

                $initialPreview = array($image->getUrl());
                $initialPreviewConfig = array(["key" => $image->id, "caption" => "Фото " . $image->id]);
            }
        }

        return [
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ];
    }

    public function actionDelete()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) return ["error" => "Не авторизован"];

        $hash = Yii::$app->request->post('hash');
        $image_id = Yii::$app->request->post('key', 0);
        $article_id = Yii::$app->request->post('article_id', 0);

        if($article_id == 0) {
            $image = ImageCache::findOne(["id" => $image_id, "hash" => $hash]);
            if(empty($image)) return ["error" => "Фото не найдено"];
            @unlink($image->path);
            $image->delete();
        } else {
            $acticle = Articles::findOne($article_id);
            if(empty($acticle)) return ["error" => "Объявление не найдено"];
            if($image_id == 0) return ["error" => "Фото не найдено"];
            $img = $acticle->getImageById($image_id);
            if(empty($img)) return ["error" => "Фото не найдено"];
            $acticle->removeImage($img);
        }

        $initialPreview = array();
        $initialPreviewConfig = array();

        return [
            'initialPreview' => $initialPreview,
            'initialPreviewConfig' => $initialPreviewConfig,
        ];
    }

    public function actionSorted()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) return ["error" => "Не авторизован"];

        $hash = Yii::$app->request->post('hash');
        $article_id = Yii::$app->request->post('article_id', 0);

        $newIndex = Yii::$app->request->post('newIndex', 0);
        $oldIndex = Yii::$app->request->post('oldIndex', 0);
        if($newIndex == $oldIndex) return ["error" => "Не могут быть равны"];

        if($article_id == 0) {
            $sort = 0;
            $images = ImageCache::find()->where(["hash" => $hash])->orderBy("sort")->all();
            foreach ($images as $key => $image) {
                if($key == $newIndex && $newIndex < $oldIndex) $sort++;
                if($key == $oldIndex) {
                    $image->sort = $newIndex;
                } else {
                    $image->sort = $sort;
                    $sort++;
                }
                if($key == $newIndex && $newIndex > $oldIndex) $sort++;
                $image->save();
            }
        } else {
            $acticle = Articles::findOne($article_id);
            if(empty($acticle)) return ["error" => "Объявление не найдено"];

            $sort = 0;
            $images = $acticle->getImages();
            foreach ($images as $key => $image) {
                if($key == $newIndex && $newIndex < $oldIndex) $sort++;
                if($key == $oldIndex) {
                    $image->sorted = $newIndex;
                } else {
                    $image->sorted = $sort;
                    $sort++;
                }
                if($key == $newIndex && $newIndex > $oldIndex) $sort++;
                $image->save();
            }
        }

        return ["status" => true];
    }

}
