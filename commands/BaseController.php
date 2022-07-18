<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Logs;
use app\models\ParserSettings;


class BaseController extends Controller
{
    protected function getSettings($type)
    {
      return ParserSettings::findOne($type);
    }

    protected function checkProcess($text)
    {
      $process = shell_exec('ps ax | grep yii');
      return mb_substr_count(mb_strtolower($process), $text) > 2;
    }

  	static function consoleLog($type, $text) {
  		echo date("[d.m.y H:i:s]" ) . " [" . Yii::$app->params['parser_types'][$type] . "]: " . $text . "\n";
      $log = new Logs(["date" => time(), "type" => $type, "message" => $text]);
      $log->save();
  	}

}
